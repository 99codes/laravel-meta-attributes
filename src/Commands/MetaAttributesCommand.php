<?php

namespace Nncodes\MetaAttributes\Commands;

use Illuminate\Console\Command;

class MetaAttributesCommand extends Command
{
    public $signature = 'laravel-meta-attributes';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
