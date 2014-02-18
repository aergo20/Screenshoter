<?php

/*

Screenshot'er
Simple PHP Class for Screenshot'er API <http://www.screenshoter.com/>

Author: Evandro Costa <www.evandro.co>
Date: Feb 17 2014
License: MIT

How to use:

$website = 'http://www.google.com/'; // Website to take screenshot
$path = './cache/'; // Folder to save image

$screen = new Screenshoter($website, $path);
$screen->device('tablet'); // optional
$screen->format('jpg'); // optional
$screen->shoot('image'); // returns OK or Error with message

*/

class Screenshoter
{

	private $website;
	private $path;
	private $device; // desktop (default) | tablet | smartphone
	private $type; // full (default) | cropped | selector
	private $size; // small | medium | large (default) | original
	private $format; // png (default) | jpg | gif
	private $selector; // jQuery selector (type=selector)
	private $endpoint; // http (default) | https

	public function __construct($website, $path){
		$this->website = $website;
		$this->path = $path;

		$this->device = "desktop";
		$this->type = "full";
		$this->size = "large";
		$this->format = "png";
		$this->selector = "";
		$this->endpoint = "http";
	}

	public function device($device){
		$this->device = $device;
	}

	public function type($type){
		$this->type = $type;
	}

	public function size($size){
		$this->size = $size;
	}

	public function format($format){
		$this->format = $format;
	}

	public function selector($selector){
		$this->format = $selector;
	}

	public function endpoint($endpoint){
		$this->endpoint = $endpoint;
	}

	public function shoot($name){

		$call = $this->endpoint."://screenshoter.com/?uri=".$this->website."&viewport=".$this->device."&type=".$this->type."&size=".$this->size."&format=".$this->format;

		if($this->type == "selector") {
			$call .= "&selector=".$this->selector;
		}

		if(strpos($name, ".") === FALSE) {
			$name .= ".".$this->format;
		}

		try {

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $call);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
			$results = curl_exec($ch);
			curl_close($ch);

			if(strpos($results, "<!DOCTYPE html>") !== FALSE) {
				return "Error. Invalid parameters";
			}

			if(!$fh = fopen($this->path.$name, "wb")){
				return "Error. Unable to open file";
			}
			fwrite($fh, $results);
			fclose($fh);

			if(filesize($this->path.$name) == 0) {
				return "Error. Unknown. Try again";
			}

		} catch (Exception $e) {
			return "Error. ".$e->getMessage();
		}

		return "OK";
	}

}
