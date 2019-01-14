@extends('../layouts.layout')
@section('content')
    <div class="row col-md-12 activities">
        <form id="form-activity" method="post" action="{{isset($activity->id) ? route('activities.update', $activity->id) : route ('activities.index') }}">
            {!! csrf_field() !!}
            {{method_field ($method)}}
            <div class="row col-md-offset-2 col-md-8">
            <fieldset class="form-group">
                <legend>
                    <h1><?php echo $title;?>
                    </h1>
                </legend>
                @if($errors->any())
                    <ul class="alert alert-danger" style="">
                        @foreach($errors->all() as $error)
                         <li> {{$error}} </li>
                        @endforeach
                    </ul>
                @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name"><span class="text-danger">*</span> Nome</label>
                                <input type="text" value="{{old('name', isset($activity->name) ? $activity->name : '')}}"  class="form-control" name="name"/>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="begin_date"><span class="text-danger">*</span> Data Inicial </label>
                                <input type="date" class="form-control" id="begin_date" value="{{old('begin_date', isset($activity->begin_date)? $activity->begin_date : '')}}" required name="begin_date" placeholder="Data Inicial"  />
                                <span class=" alert-danger info-data" type="hidden">Data inicial não pode ser menor que a final</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date"> Data Final</label>
                                <input type="date" class="form-control" id="final_date" value="{{old('final_date', isset($activity->final_date) ? $activity->final_date : '')}}" name="final_date" placeholder="Data Final" />
                                <span class=" alert-danger info-data" type="hidden">Data final não pode ser menor que a inicial</span>
                            </div>
                        </div>
                    </div>
                    @php $status_id = $activity->status_id @endphp
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status"><span class="text-danger">*</span> Status</label>
                                <select name="status_id"  class="form-control">
                                    @forelse($statuses as $status)
                                        <option {{old('status_id', $status_id) == $status->id ? 'selected="selected"': ''}} value="{{$status->id}}">{{$status->status}}</option>
                                    @empty
                                        <option value="">Sem Dados</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        @php $stituation = $activity->situation @endphp
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="situation"><span class="text-danger">*</span> Situação </label>
                                <select name="situation" class="form-control">
                                    <option {{old('situation', $stituation) == 'Ativo' ? 'selected': ''}}  value="ativo">Ativo</option>
                                    <option {{old('situation', $stituation)  == 'Inativo' ? 'selected': ''}}  value="inativo">Inativo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description"><span class="text-danger">*</span> Descrição </label>
                                <textarea class="form-control" name="description"  rows="5">{{old('description', trim(isset($activity->description) ? $activity->description :''))}} </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" id="btn-send-activity" style="width: 100%;"> Salvar </button>
                        </div>
                    </div>

            </fieldset>
            </div>
        </form>
    </div>

@endsection

