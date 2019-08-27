<?php

namespace App\Http\Controllers;
use App\Activity;
use Illuminate\Http\Request;
use App\Status;
use Illuminate\Database\QueryException;


class ActivityController extends Controller
{

	protected $_activity_model;

	public function __construct () {
		$this->_activity_model = new Activity();
	}

	public function index(Request $request, Activity $activity){

		$status = isset($request->all()['status']) ? $request->all()['status'] : '';
		$situation = isset($request->all()['situation']) ? $request->all()['situation'] : '' ;
		if(!empty($request->all())){
			$dataForm = $request->all();
			$activities = $activity->search($dataForm);
			return view('activities.index', compact (['activities', 'status', 'situation'] ));
		}
		else {
			$activities = $activity->allActivity();
			if(empty($activities->toArray ())){
				return redirect ()->route('activities.create');
			}
			else
				return view('activities.index', compact (['activities', 'status', 'situation']));
		}
	}

	public function create(Activity $activity){
		$method = 'POST';
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
			'description.max:600' => 'O Campo Descrição não deve conter mais de 600 caracteres',
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


