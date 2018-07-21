/*
 By Abi Salazar https://abisalazar.co.uk/ && https://development.abisalazar.co.uk/
 Available for use under the MIT License
 */ 



(function ( $ ) {

                $.fn.contentLoader = function( options ) {

                    /*
                        Laravel Content Loader Options
                    */

                    this.settings = $.extend({
                        url: "/load",
                        data : {},
                        csrfToken:$('meta[name="csrf-token"]').attr('content') || Laravel.csrfToken,
                        auto: true,
                        ajaxType : "GET",
                        contentDataType: null,
                        lastPage : null,
                        results: '#' + $(this).attr('id') + "_results",
                        response: function (response) {
                           alert("You must add a response function.");
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    }, options );

                    // Setting up the laravel number page.

                    this.page = (this.settings.auto)? 0 : 1;

                    // Setup callback when loader button is click
                    this.on('click', function () {
                        this.page ++;
                        this.request();
                    }.bind(this));

                    // Sends ajax request to the server.

                    this.request = function () {
                      $.ajax({
                          url: this.settings.url + "?page=" + this.page + '&' +this.settings.contentDataType,
                          data: this.settings.data,
                          dataType: "JSON",
                          type: this.settings.ajaxType,
                          headers: {
                              'X-CSRF-TOKEN': this.settings.csrfToken
                          },
                          success : function (response) {
                              this.settings.response(response);
                              this.loadBtn(response);
                          }.bind(this),
                          error :function (error) {
                              this.settings.error(error);
                          }.bind(this)
                      });
                    };

                    // Hides Load Button if required

                    this.loadBtn = function (response) {
                        this.settings.lastPage = response.last_page;
                       if(this.page >=  this.settings.lastPage){
                           $(this).hide();
                       }

                    };

                    // If Auto is set to true, it sends the first ajax request automatically.
                    if(this.settings.auto){
                        this.page ++;
                        this.request();
                    }

                };

            }( jQuery ));