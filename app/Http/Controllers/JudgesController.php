<?php

namespace App\Http\Controllers;

use App\Http\Requests\Judge\JudgeRequest;
use App\Models\Judge;
use Auth;

class JudgesController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin(true)) {
            $title = 'Все судьи';

            $judges = Judge::all();

            $judgesCount = count($judges);
            $judges = $judges->sortByDesc('id')->paginate(20)->appends(request()->query());

            $data=[
                'title' => $title,
                'judges' => $judges,
                'judgesCount' => $judgesCount,
            ];
            return view('pages.judges.admin.index', $data);
        }

        return to_route('user.logout')->with('error', 'нет права!');
    }

    public function store(JudgeRequest $request)
    {
        if (Auth::user()->isAdmin(true)) {
            $data = $request->validated();

            $judge = new Judge(array_filter($data));
            $judge->save();

            return to_route('judges.index')
                ->with('success', 'Вы успешно зарегистрировали судью.');
        }

        return to_route('champions.index')->with('error', 'нет права!');
    }

    public function edit(Judge $judge)
    {
        if (Auth::user()->isAdmin(true)) {
            $judge = Judge::with([ ])->find($judge->id);

            return view('pages.judges.admin.edit', [
                'judge' => $judge,
                'title' => 'Изменить данные судьи',
                'checked' => true,
            ]);
        }

        return to_route('champions.index')->with('error', 'нет права!');
    }

    public function update(JudgeRequest $request, Judge $judge)
    {
        if (Auth::user()->isAdmin(true)) {
            $data = $request->validated();

            $judge = Judge::Edit($data, $judge->id);
            return to_route('judges.index')
                ->with('success', 'Вы успешно изменили данные судьи '. $judge->fullName);
        }

        return to_route('champions.index')->with('error', 'нет права!');
    }

    public function destroy(Judge $judge)
    {
        if (Auth::user()->isAdmin(true)) {
            try {
                $judge->delete();
                return to_route('judges.index')
                    ->with('success', 'Судья удалён!');
            }
            catch (\Exception $exception)
            {
                return to_route('champions.index')
                    ->with('errors', 'Судья не может быть удалён');
            }
        }
        return redirect()->back()->with('error', 'нет права!');
    }

    public function deleteAll()
    {
        if (Auth::user()->isAdmin(true)) {
            Judge::truncate();

            return redirect()->back()->with('success', 'Судьи удалены');
        }

        return to_route('champions.index')->with('error', 'нет права!');
    }
}
