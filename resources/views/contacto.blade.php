@extends('layouts.site')

@section('otros')
<link href="{{ asset('css/contact-form.css') }}" rel="stylesheet">
<style>
.select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 38px;
    user-select: none;
    -webkit-user-select: none;
    }
</style>
@endsection
@section('content')
	   <!-- Section: contact -->
  	<section id="contact-form-section" class="form-content-wrap">
		<div class="container">
			<div class="row">
				<div class="tab-content">
					<div class="col-sm-12">
						<div class="item-wrap">
							<div class="row">
								
								<div class="col-sm-12">
									<div class="item-content colBottomMargin">
										<div class="item-info">
											<h2 class="item-title text-center">Contactenos</h2>
											
										</div><!--End item-info -->
										
								   </div><!--End item-content -->
								</div><!--End col -->
								<div class="col-md-12">
								
								
                                    {!! Form::open(['url'=>'eniarcorreo','method'=>'POST','class'=>'horizontal-form popup-form','id'=>'contactForm']) !!}
												<div class="row">
													<div id="msgContactSubmit" class="hidden"></div>
													
													<div class="form-group col-sm-6">
														<div class="help-block with-errors"></div>
														<input name="fname" id="fname" placeholder="Tu nombre*" class="form-control" type="text" required data-error="Por favor ingresa tu nombre"> 
														<div class="input-group-icon"><i class="fa fa-user"></i></div>
													</div><!-- end form-group -->
													<div class="form-group col-sm-6">
														<div class="help-block with-errors"></div>
														<input name="email" id="email" placeholder="Tu E-mail*" pattern=".*@\w{2,}\.\w{2,}" class="form-control" type="email" required data-error="Ingresar correo electrónico válido">
														<div class="input-group-icon"><i class="fa fa-envelope"></i></div>
													</div><!-- end form-group -->
													<div class="form-group col-sm-2">
                                                         <select name="country" id="country_list" class="">
                                                             <option></option>
                                                            @foreach($countries as $c)
                                                             <option  data-img-src="{{asset('flags/'.strtolower($c->id).'.png') }}" value="{{ $c->codigo }}">{{ $c->country }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="input-group-icon"><i class="fa fa-map-o"></i></div>
                                                    </div>
													<div class="form-group col-sm-4">
														
														<input name="phone" id="phone" placeholder="Teléfono" pattern="[0-9]{11}" class="form-control" type="tel"  data-error="Por favor ingresa un número de teléfono valido">
														<div class="input-group-icon"><i class="fa fa-phone"></i></div> 
                                                        
                                                        <div class="help-block with-errors"></div>
													</div><!-- end form-group -->
													<div class="form-group col-sm-6">
														<div class="help-block with-errors"></div>
														<input name="subject" id="subject" placeholder="Asunto*" class="form-control" type="text" required data-error="Por favor ingresa el asunto">
														<div class="input-group-icon"><i class="fa fa-book"></i></div> 
													</div><!-- end form-group -->
													<div class="form-group col-sm-12">
														<div class="help-block with-errors"></div>
														<textarea rows="3" name="message" id="message" placeholder="Escribe tu comentario aquí*" class="form-control" required data-error="Por favor ingresa un mensaje"></textarea>
														<div class="textarea input-group-icon"><i class="fa fa-pencil"></i></div>
													</div><!-- end form-group -->
													
													<div class="form-group last col-sm-12">
														<button type="submit" id="submit" class="btn btn-custom"><i class='fa fa-envelope'></i> Enviar</button>
													</div><!-- end form-group -->	
											
													<span class="sub-text">* Campos requeridos</span>
													<div class="clearfix"></div>
												</div><!-- end row -->
											{!! Form::close() !!}
											
											
									
									
								  
								
								</div>
							</div><!--End row -->
							
						
								
							
							<!-- Popup end -->
							
						</div><!-- end item-wrap -->
					</div><!--End col -->
				</div><!--End tab-content -->
			</div><!--End row -->
		</div><!--End container -->
	</section>
@endsection
@section('scripts')
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/validator.min.js') }}"></script>
<script src="{{ asset('js/contact-form.js') }}"></script>
<script>
 $(function(){
    $("#country_list").select2({
        placeholder: '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Seleccionar',
        templateResult: format,
        templateSelection: format,
        width: 'auto', 
        escapeMarkup: function(m) {
            return m;
        }
    });

})   
    
function format(state) {
        if (!state.id) { return state.text; }
        var flag = $(state.element).data('img-src').toLowerCase();
        var $state = $(
         '<span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<img src="' + flag + '" style="width: auto;" /> ' + state.text + ' (' + state.element.value + ' )' + '</span>'
        );
        return $state;
    }
</script>

@endsection