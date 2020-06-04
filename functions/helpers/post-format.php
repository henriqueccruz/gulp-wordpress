<?php
/**
 * Post format functions and abstractions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

class YouTubeLinkParser {
	
	function __construct($video_url) {
		$this->video_id = $this->get_video_id($video_url);
	}

	protected function get_video_id($url) {
		preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
		$youtube_id = $match[1];
	
		return $youtube_id;
	}

	public function get_id() {
		return $this->video_id;
	}

	public function get_video_thumbnail() {
		return "https://img.youtube.com/vi/{$this->video_id}/0.jpg";
	}

	public function get_video_embed_url() {
		return "https://www.youtube.com/embed/{$this->video_id}";
	}

	public function get_video_embed() {
		$embed_url = $this->get_video_embed_url();
		return "<iframe width='560' height='315' src='{$embed_url}' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
	}
}