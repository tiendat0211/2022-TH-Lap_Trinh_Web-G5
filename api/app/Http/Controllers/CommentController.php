<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Manga;
use App\Models\Category;
use App\Models\Manga_category;

class CommentController extends Controller
{
    public function newest()
    {
        return  DB::select("SELECT chapter_manga.chapter_name as chapter_name, comment.chapter_id, mangas.id as manga_id,
        mangas.name as manga_name, 
        users.name as user_name, content, 
        users.avatar as user_avatar
        from comment, mangas, chapter_manga, users 
        where comment.chapter_id=chapter_manga.chapter_id and comment.user_id=users.id and chapter_manga.manga_id=mangas.id
        ORDER BY comment.created_at ASC");
    }
    public function getCommentOfChapter($chapterID)
    {
        return  DB::select("SELECT users.name as user_name, content from comment, chapter_manga, users 
        where comment.chapter_id=chapter_manga.chapter_id and comment.user_id=users.id and comment.chapter_id=$chapterID
        ORDER BY comment.created_at ASC");
    }
    public function getCommentOfManga($mangaID)
    {
        return  DB::select("SELECT users.name as user_name, content from comment, chapter_manga, users ,mangas
        where comment.chapter_id=chapter_manga.chapter_id and comment.user_id=users.id and chapter_manga.manga_id=mangas.id
        and chapter_manga.manga_id=$mangaID
        ORDER BY comment.created_at ASC");
    }
    public function addNewComment(Request $request)
    {
        $values = array('chapter_id' => $request->chapter_id, 'user_id' => $request->user_id, 'content' => $request->content);
        $import = DB::table('comment')->insert($values);
        return $import;
    }
}
