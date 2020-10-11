<?php 
namespace logs;
use Illuminate\Support\Facades\App;
class logs_hub{
    public $env;
    function __construct(){
    }
    function log($msg, $application, $level,$execution_time, $environment, $user_id=null, $extra_data=null){
        $now =time();
        $data=[
            "message"=> $msg,
            "level"=> $level,
            "application"=> $application,
            "environment"=> $environment,
            "user_id"=> $user_id,
            "execution_time"=>$execution_time,
            "extra_data"=> $extra_data,
            "timestamp"=> $now
        ];

        error_log(json_encode($data), 3, App::environment('DIR')."$now.log");
        return $data;
    }
    function warning($msg, $application, $execution_time, $environment, $user_id=null, $extra_data=null){
        $this->log($msg, $application, App::environment('WARNING'),$execution_time, $environment, $user_id, $extra_data);
    }
    function info($msg, $application, $execution_time, $environment, $user_id=null, $extra_data=null){
        $this->log($msg, $application, App::environment('INFO') ,$execution_time, $environment, $user_id, $extra_data);
    }
    function error($msg, $application, $execution_time, $environment, $user_id=null, $extra_data=null){
        $this->log($msg, $application, App::environment('ERROR'),$execution_time, $environment, $user_id, $extra_data);
    }
    function critical($msg, $application, $execution_time, $environment, $user_id=null, $extra_data=null){
        $this->notify($this->log($msg, $application,  App::environment('CRITICAL') ,$execution_time, $environment, $user_id, $extra_data));
    }
    function notify($data){
        $payload = json_encode($data);
        $ch = curl_init( App::environment('NOTIFY_API'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        $result = curl_exec($ch);
        curl_close($ch);
    }
}
?>