<?php

/**
 * Offical News Sample
 * @ref: https://codeigniter.com/user_guide/tutorial/news_section.html
 */

namespace App\Models;

use App\System\Model;

class NewsModel extends Model
{
    protected $table = 'news';

    protected $allowedFields = ['title', 'slug', 'body'];

    /**
     * @param false|string $slug
     *
     * @return array|null
     */
    public function getNews($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}

