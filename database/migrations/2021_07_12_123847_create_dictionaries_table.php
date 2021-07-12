<?php

use App\Models\Language;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $langPrimaryKey = (new Language)->getKeyName();
        $langTable = (new Language)->getTable();
        Schema::create('dictionaries', function (Blueprint $table) use ($langPrimaryKey, $langTable) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->unsignedBigInteger('from_language_id');
            $table->unsignedBigInteger('to_language_id');

            $table->foreign('from_language_id')->references($langPrimaryKey)->on($langTable);
            $table->foreign('to_language_id')->references($langPrimaryKey)->on($langTable);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dictionaries');
    }
}
