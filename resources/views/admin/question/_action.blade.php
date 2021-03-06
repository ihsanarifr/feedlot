{!! Form::model($model, ['url' => $delete_url, 'method' => 'delete', 'class' => 'form-inline js-confirm', 'data-confirm' => $confirm_message ]) !!}
	@if($model->answers()->count() == 0)
    		<a href="{{ $edit_url }}" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> Jawab</a>
    	@else
    		<a href="{{ $edit_answer }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i>Edit</a>
    	@endif
    {!! Form::button('<i class="fa fa-trash"></i> Hapus', ['class'=>'btn btn-xs btn-danger','type'=>'submit']) !!}
{!! Form::close()!!}