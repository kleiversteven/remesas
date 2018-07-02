@extends('layouts.site')




@section('main-content')
	   <!-- Section: contact -->
    <section id="contact" class="home-section nopadd-bot color-dark bg-white text-center">
        <div class="banner-emoji wow  flipInY" data-wow-offset="10" data-wow-delay="0.6s">
            
        </div>
		<div class="container marginbot-50">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="wow flipInY" data-wow-offset="0" data-wow-delay="0.4s">
					<div class="section-heading text-center">
					<p></p>
					</div>
					</div>
				</div>
			</div>

		</div>
		
		<div class="container">

			<div class="row marginbot-80">
				<div class="col-md-6 col-sm-12 ">
                    <img src="{{ asset('image/logo.jpg') }}" >
                </div>
				<div class="col-md-6 col-sm-12 ">
		            <div id="sendmessage"></div>
                    <div id="errormessage"></div>
                    <form action="" method="post" role="form" class="contactForm">
                       {!! csrf_field() !!}
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Nombre" data-rule="minlen:4"  />
                            <div class="validation"></div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="email" id="email" placeholder="Correo" data-rule="email" />
                            <div class="validation"></div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Asunto" data-rule="minlen:4" />
                            <div class="validation"></div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="message" id="message" rows="5" data-rule="required" placeholder="Mensaje"></textarea>
                            <div class="validation"></div>
                        </div>
                        
                        <div class="text-center"><button type="submit" class="btn btn-skin btn-lg btn-block">Enviar</button></div>
                    </form>
				</div>
			</div>	


		</div>

	</section>
@endsection
