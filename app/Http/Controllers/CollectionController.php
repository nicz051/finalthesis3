<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class collectionController extends Controller
{
    public function getCollections(){
        exec("mode COM1 BAUD=115200 PARITY=N data=8 stop=1 xon=off");
    
        $fp = fopen ("COM1", "w+");
        if ( !$fp ){
            return "Not open";
        }else {
            fwrite( $fp, "AT\n\r" );
            usleep( 500000 );
            fwrite( $fp, "AT+CMFG=1\n\r" );
            usleep( 500000 );
            fwrite( $fp, "AT+CMGS=" + "639987653629" + "\n\r" );
            usleep( 500000 );
            fwrite( $fp, 'hi' + "\n\r" );
            usleep( 500000 );
            fwrite( $fp, chr(26) );
            usleep( 7000000 );
            fclose( $fp );
            // $message=fread($fp,1);
            // fclose($fp);
        return 'open';
        }
        

    }
    public function getCollection(){
        
    }
    public function createCollection(){
        
    }
    public function updateCollection(){
        
    }
    public function deleteCollection(){
        
    }
}
