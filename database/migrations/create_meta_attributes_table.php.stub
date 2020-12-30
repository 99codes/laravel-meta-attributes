<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetaAttributesTable extends Migration
{
    public function up()
    {
        Schema::create('meta_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('key');
            $table->text('value');
            $table->string('type');

            $table->uuidMorphs('model');

            $table->timestamps();
        });
    }
}
