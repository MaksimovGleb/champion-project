<?php

namespace App\Http\Controllers;

use App\Http\Requests\Champion\ChampionRequest;
use App\Models\Champion;
use Auth;

class ChampionsController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin(true)) {
            $title = 'Все участники';

            $champions = Champion::all();

            $championsCount = count($champions);
            $champions = $champions->sortByDesc('id')->paginate(20)->appends(request()->query());

            $data=[
                'title' => $title,
                'champions' => $champions,
                'championsCount' => $championsCount,
            ];
            return view('pages.champions.admin.index', $data);
        }

        return to_route('user.logout')->with('error', 'нет права!');
    }

    public function store(ChampionRequest $request)
    {
        if (Auth::user()->isAdmin(true)) {
            $data = $request->validated();

            $champion = new Champion(array_filter($data));
            $champion->save();

            return to_route('champions.index')
                ->with('success', 'Вы успешно зарегистрировали участника.');
        }

        return to_route('champions.index')->with('error', 'нет права!');
    }

    public function edit(Champion $champion)
    {
        if (Auth::user()->isAdmin(true)) {
            $champion = Champion::with([ ])->find($champion->id);

            return view('pages.champions.admin.edit', [
                'champion' => $champion,
                'title' => 'Изменить данные участника',
                'checked' => true,
            ]);
        }

        return to_route('champions.index')->with('error', 'нет права!');
    }

    public function update(ChampionRequest $request, Champion $champion)
    {
        if (Auth::user()->isAdmin(true)) {
            $data = $request->validated();

            $champion = Champion::Edit($data, $champion->id);
            return to_route('champions.index')
                ->with('success', 'Вы успешно изменили данные участника '. $champion->fullName);
        }

        return to_route('champions.index')->with('error', 'нет права!');
    }

    public function destroy(Champion $champion)
    {
        if (Auth::user()->isAdmin(true)) {
            try {
                $champion->delete();
                return to_route('champions.index')
                    ->with('success', 'Участник удалён!');
            }
            catch (\Exception $exception)
            {
                return to_route('champions.index')
                    ->with('errors', 'Участник не может быть удалён');
            }
        }
        return redirect()->back()->with('error', 'нет права!');
    }

    public function deleteAll()
    {
        if (Auth::user()->isAdmin(true)) {
            Champion::truncate();

            return redirect()->back()->with('success', 'Участники удалены');
        }

        return to_route('champions.index')->with('error', 'нет права!');
    }
}
