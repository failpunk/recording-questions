<?php

class ProcessLogPeer extends BaseProcessLogPeer
{
    public static function addLog($name, $description)
    {
        if($name && $description)
        {
            $log = new ProcessLog();
            $log->setName($name);
            $log->setDescription($description);

            $log->save();
        }
    }
    
    public static function getYesterdaysLogs()
    {
        $from = date('Y-m-d h:i:s', time() - 86400);
        $to = date('Y-m-d h:i:s');
        
        return DbFinder::from('ProcessLog')
					        ->filterBy('CreatedAt', array('from' => $from, 'to' => $to))
					        ->find();
    }
}
