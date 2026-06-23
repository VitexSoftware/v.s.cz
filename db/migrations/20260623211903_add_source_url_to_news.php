<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddSourceUrlToNews extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('news');
        $table
            ->addColumn('source_url', 'string', ['limit' => 512, 'null' => true, 'default' => null])
            ->addIndex(['source_url'], ['unique' => true, 'name' => 'idx_news_source_url'])
            ->update();
    }
}
