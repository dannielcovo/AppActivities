<?php

namespace App\Http\Controllers;
use App\Activity;
use Illuminate\Http\Request;
use App\Status;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{

	protected $_activity_model;

	public function __construct () {
		$this->_activity_model = new Activity();
	}

	public function index(){
		$activities = $this->allActivity();

		if(empty($activities))
			return redirect ()->route('activities.create');
		else
			return view('activities.index', compact ('activities', $activities));
	}

	public function create(){
		$method = 'POST';
		$activity = new Activity();
		$statuses = Status::all();
		$title = 'Cadastrar Atividade';
		return view('activities.form',compact ('title', $title, 'statuses', $statuses, 'method', $method, 'activity', $activity));
	}

	public function store(Request $request){

		$this->_validate ($request);
		try{
			Activity::create($request->all());
			flash()->success('Atividade Criada Com Sucesso');
			return redirect ()->route('activities.index');
		} catch (QueryException $e) {
			flash()->error('Houve um erro Inesperado');
			return redirect()->back();
		}
	}

	public function update(Request $request, $id){

		$this->_validate ($request);
		$activity = Activity::findOrFail($id);
		if(!empty($activity)){
			try{
				$data = $request->all ();
				$activity->fill($data);
				$activity->save();
				flash()->success('Atividade Alterada com Sucesso');
				return redirect ()->route('activities.index');
			}catch (QueryException $e) {
				flash()->error($e->getMessage());
				return redirect()->back();
			}


		}
	}

	public function show(Activity $activity){
		return redirect ()->route('activities.index');
	}

	public function edit(Activity $activity){

		//transformando em array simples
		$statuses = Status::all();

		$method = 'PUT';
		if(empty($activity)) {
			$msg = 'Atividade não Existe';
		} else if($activity->status_id == 4) {
			$msg = 'Essa atividade já foi concluída, não é possível alterá-la';
		}
		else{
			$title = 'Editar Atividade';
			return view('activities.form', compact ('activity', $activity, 'title', $title, 'method', $method, 'statuses', $statuses));
		}

		flash()->error($msg);
		return redirect ()->route('activities.index');

	}

	public function destroy( Activity $activity){
		$activity->delete();
		flash()->success('Atividade Deletada com Sucesso');
		return redirect ()->route('activities.index');
	}



	private function findActivity($id){

		//chamada procedure atividade by id
		try{
			$activity = DB::select (
				"call select_activity_by_id($id)"
			);

		} catch (Exception $e){
			flash()->error('Ocorreu um erro inesperado, temte novamente');
			return redirect ()->to('/index');
		}

		return $activity;

	}

	private function allActivity(){
		$activity = DB::select ("select activities.id, name, status, begin_date, final_date, situation, description from activities JOIN statuses on activities.status_id = statuses.id");
		return $activity;
	}

	protected function _validate(Request $request){
		$rules = [
			'name' => 'required|max:255',
			'description' => 'required|max:600',
			'begin_date' => 'required|date',
			'status_id' => 'required',
			'situation' => 'required'

		];
		$messageDefault =[
			'name.required' => 'Campo Nome não pode ser Vazio',
			'description.required' => 'Campo Descrição não pode ser Vazio',
			'begin_date.required' => 'Campo Data de Inicio não pode ser Vazio',
			'status_id.required' => 'Campo Status nãi pode ser vazio',
			'situation.required' => 'Campo Situação não pode ser Vazio',
		];

		$validDate = ['final_date'=>'date|required'];
		$msgException = ['final_date.required' => 'Você não pode finalizar uma Atividade sem definir uma data Final'];

		$this->validate ($request, $request->status_id == 4 ? $validDate : $rules,
			$request->status_id == 4 ? $msgException : $messageDefault
		);

	}

}


