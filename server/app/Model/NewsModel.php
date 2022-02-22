<?php

namespace App\Model;
use App\Utils\DBConnector;
/**
 * Class NewsModel
 *
 *
 * @package App\Model
 */
class NewsModel extends BaseModel
{
    /**
     * @var
     */
    public int $id;
    /**
     * @var
     */
    public string $title;
    /**
     * @var string
     */
    public string $content;
    /**
     * @var
     */
    public string $date;

    /**
     * @var string
     */
    public string $tableName = 'news';
    /**
     * @var array|string[]
     */
    protected array $fields = [
        'id',
        'title',
        'content',
        'date'
    ];

    /**
     * @param string $title
     * @param string $content
     */
    public function __construct(string $title = '', string $content = '')
    {
        $this->title = $title;
        $this->content = $content;
    }

}