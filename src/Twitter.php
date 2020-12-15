<?php

namespace fffaraz\Utils;

class Twitter
{
    public static function connection()
    {
        $connection = new \Abraham\TwitterOAuth\TwitterOAuth(env('TWITTER_CONSUMER_KEY'), env('TWITTER_CONSUMER_SECRET'), env('TWITTER_ACCESS_TOKEN'), env('TWITTER_ACCESS_SECRET'));
        $connection->setDecodeJsonAsArray(true);
        return $connection;
    }

    public static function verify()
    {
        return Twitter::connection()->get("account/verify_credentials");
    }

    public static function post($text)
    {
        return Twitter::connection()->post('statuses/update', ['status' => $text]);
    }

    public static function media($text, $filename)
    {
        $connection = Twitter::connection();
        $media = $connection->upload('media/upload', ['media' => $filename]);
        print_r($media);
        $parameters = [
            'status' => $text,
            'media_ids' => implode(',', [$media->media_id_string]),
        ];
        return $connection->post('statuses/update', $parameters);
    }

    public static function retweet($id)
    {
        return Twitter::connection()->post("statuses/retweet", ["id" => $id]);
    }

    public static function like($id)
    {
        return Twitter::connection()->post("favorites/create", ["id" => $id]);
    }

    public static function unlike($id)
    {
        return Twitter::connection()->post("favorites/destroy", ["id" => $id]);
    }

    public static function search($query)
    {
        return Twitter::connection()->get("search/tweets", ["q" => $query]);
    }

    public static function userById($id)
    {
        return Twitter::connection()->get('users/show', ['user_id' => $id, 'include_entities' => true]);
    }

    public static function userByName($screenname)
    {
        return Twitter::connection()->get('users/show', ['screen_name' => $screenname, 'include_entities' => true]);
    }

    public static function listMembers($slug, $screenname)
    {
        // https://developer.twitter.com/en/docs/accounts-and-users/create-manage-lists/api-reference/get-lists-members
        return Twitter::connection()->get('lists/members', ['slug' => $slug, 'owner_screen_name' => $screenname, 'count' => 5000]);
    }
}
