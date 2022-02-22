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
     * @var int
     */
    public int $id;
    /**
     * @var string
     */
    public string $title;
    /**
     * @var string
     */
    public string $content;
    /**
     * @var string
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