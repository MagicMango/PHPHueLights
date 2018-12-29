<?php
namespace Controller;


class LightController
{

    private $colors = [0, 8500, 17000, 25500, 34000, 46920, 48000, 54000, 60000];
    /***
     * Will change the ABZ Stripe Plus for the Stream!
     * @param $id of Lamp
     * @param $color color of user choice in chat
     * @param string $mode modus of choice
     * @return resource something \^^/
     */
    public function controlLight($id, $color, $mode = "normal"){
            $hue = $this->translateColorToNumber($color);
            $lampmode = $this->translateModeToHueMode($mode);
            if($lampmode == "normal" || $lampmode == "own"){
                $data = array(
                        "hue"=>$hue,
                        "sat"=>254);
            }else {
                $data = array(
                        "hue" => $hue,
                        "alert" => $lampmode,
                        "sat" => 254);
            }
            return $this->executeMode($id, $lampmode, $data);
    }

    /***
     * @param $color
     * @return int
     */
    private function translateColorToNumber($color){
        switch ($color) {
            case "red":
                $hue = 0;
                break;
            case "orange":
                $hue = 8500;
                break;
            case "yellow":
                $hue = 17000;
                break;
            case "green":
                $hue = 25500;
                break;
            case "white":
                $hue = 34000;
                break;
            case "blue":
                $hue = 46920;
                break;
            case "purple":
                $hue = 48000;
                break;
            case "magenta":
                $hue = 54000;
                break;
            case "pink":
                $hue = 60000;
                break;
            default:
                $hue = 0;
        }
        return $hue;
    }

    /**
     * @param $mode
     * @return string
     */
    private function translateModeToHueMode($mode)
    {
        $huemode = "normal";
        switch($mode){
            case "blink":
                $huemode = "lselect";
                break;
            case "disco":
                $huemode = "own";
                break;
            default:
                $huemode = "normal";
                break;

        }
        return $huemode;
    }

    private function executeMode($id, $lampmode, $data)
    {
        $address = "http://[ip]/api/[usertoken]/";
        $method = "lights/".$id."/state";
        $address.=$method;
        if($lampmode == "own"){
            foreach ($this->colors as $color){
                $data["hue"] = $color;
                $data["alert"] = "select";
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $address);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                curl_exec($curl);
                curl_close($curl);
                sleep(1);
            }
        }else {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $address);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_exec($curl);
            curl_close($curl);
        }
        return $curl;
    }
}