<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
public function up()
{
Schema::create('questions', function (Blueprint $table) {
$table->id();
$table->string('title');
$table->text('body');
$table->foreignId('user_id')->constrained()->onDelete('cascade');
$table->timestamps();
});
}

public function down()
{
Schema::dropIfExists('questions');
}
}
