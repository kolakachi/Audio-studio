<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WhiteLabelConfigModel;
use Illuminate\Support\Facades\Log;

class GenerateCustomDomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:domains';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Valid Tracking Domains';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
       $this->generateCnames();
    }

    public function generateCnames()
    {
        $domain = 'sn1.audiostudio.cc';
        $ip = gethostbyname($domain);
        $cnames = '';
        $history = [];
        $generated = [];
        $cnames_chunk_size = 50;

        $traking_domains = WhiteLabelConfigModel::all();

        if ($traking_domains) {
            
            $this->question('Starting');

            $bar = $this->output->createProgressBar(count($traking_domains));

            $bar->start();

            foreach ($traking_domains as $traking_domain) {
                // && $traking_domain->domain != "https://app.audio.co"
                if (!empty($traking_domain->domain)) {

                    $parsed_url = parse_url($this->addProtocol($traking_domain->domain));
                    $cname = isset($parsed_url['host'])? rtrim($parsed_url['host'], '.') : '';

                    try 
                    {  
                        if(in_array($cname, $history)) continue;

                        $cname_ip = gethostbyname($cname); // Works
                        if ($cname_ip === $ip){
                            $this->comment(' Processing: '.$this->addProtocol($cname));
                            $history[] = $cname;
                            $url = $this->addProtocol($cname).'/domain/cname_valid.txt';
                            $fp = @fopen($url,'r');
                            $pointed = @fread($fp, 8);

                            if (rtrim($pointed) == 'valid') {
                                $cnames .= $cname . ', ';
                                $generated[] = $cname;
                                $traking_domain->status = 2;
                                $traking_domain->save();
                            }
                        }
                    }
                    catch (Exception $e)
                    {
                        Log::info('Cant process host name: ', $e->getMessage());
                    }
                }
                $bar->advance();
            }
            $chunks = array_chunk($generated,$cnames_chunk_size);

            foreach ($chunks as $key => $chunk){
                $server_key = $key+1;
                $host_domain = ['sn'.$server_key.'.audiostudio.cc'];
                $chunk = array_merge($host_domain, $chunk);
                $grouped_cnames = implode(',',$chunk);
                file_put_contents('./public/.whitelabel-domains-'.$server_key, rtrim($grouped_cnames, ', '));
            }

            $bar->finish();
            $this->info(' Generated '.count($chunks).' servers and '.count($generated).' custom domains');
          
        }else{
            $this->info(' Nothing to do');
        }
    }

    protected function addProtocol($url, $scheme = 'http://')
    {
        return parse_url($url, PHP_URL_SCHEME) === null ?
        $scheme . $url : $url;
    }

    protected function enforceHttps($url='')
    {
        return str_replace('http://', 'https://', $url);
    }

    public function generateSSL()
    {
       exec('sudo certbot -q --agree-tos --cert-name sn1.audiostudio.cc certonly --webroot --webroot-path /opt/bitnami/apache2/htdocs/app.audiostudio.cc/public -m davmixcool@gmail.com -d "$(< /opt/bitnami/apache2/htdocs/app.audiostudio.cc/public/.whitelabel-domains)" --post-hook ~/custom-domain-vhost.sh');
    }
   
   
   
}
