<?php
class TwitterHelper extends AppHelper {
	
	public function parseContent($content) {
		$content = html_entity_decode($content);
		$content = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $content);
		$content = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $content);
		$content = preg_replace("/@(\w+)/", "<a href=\"http://twitter.com/#!/\\1\" target=\"_blank\">@\\1</a>", $content);
		$content = preg_replace("/#(\w+)/", "<a href=\"http://twitter.com/#!search/%23\\1\" target=\"_blank\">#\\1</a>", $content);
		return $content;
	}
}
