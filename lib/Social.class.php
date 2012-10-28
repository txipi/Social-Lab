<?php
// lib/Social.class.php
class Social
{
  static public function slugify($text)
  {
    // replace all non letters or digits by -
    $text = preg_replace('/\W+/', '-', $text);
 
    // trim and lowercase
    $text = strtolower(trim($text, '-'));
 
    return $text;
  }

  static public function getUnixTimestamp($datetime = null)
  {
    return date("U", (($datetime) ? strtotime($datetime) : time()));
  }

  static public function sendMessage($from_id, $to_id, $text, $public)
  {
    $message = new Message();
    $message->setFromId($from_id);
    $message->setToId($to_id);
    $message->setText($text);
    $message->setIsPublic($public);
    $message->setIsUnread(true);
    $message->save();
  }

  static public function tag($user, $pic)
  {
    $tag = new Tag();
    $tag->setUserId($user);
    $tag->setPictureId($pic);
    $tag->save();
  }
}
