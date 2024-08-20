<?php

namespace ADReviewManager\Models;

if (!defined('ABSPATH')) {
    exit;
}

use ADReviewManager\Models\Model;

class Comment extends Model
{
    protected $table = 'adrm_review_comments';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    public function create($data)
    {
        $data['created_at'] = current_time('mysql');
        $data['updated_at'] = current_time('mysql');
        return $this->insert($data);
    }

    public function getComments($reviewID)
    {
        $comments = $this->where('review_id', $reviewID)
            ->get();
        return $comments;
    }

    public function getComment($id, $key = 'id')
    {
        $comment = $this->where($key, $id)
            ->first();
        return $comment;
    }

    public function updateComment($id, $data)
    {
        $data['updated_at'] = current_time('mysql');
        return Comment::where('id', $id)
            ->update($data);
    }

    public function deleteComment($id)
    {
        return Comment::where('id', $id)
            ->delete();
    }
}