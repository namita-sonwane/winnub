/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
  
  $("#selecttype").change(function(){
      var selezione=$(this).find("option:selected").val();
      if(selezione =="null"){
          
        $(".formselection").addClass("hide");
        
      }else{
        
        $(".formselection").removeClass("hide");
      }
      
      
  });
  
  
    $( "#formregister" ).validate({
            rules: {
              password: "required",
              re_password: {
                equalTo: "#password"
              },
              nomeazienda:{
                  required: true

              },
              username:{
                   required: true,
                   remote:{
                        url: "/"+SITE_BASE_LANG+"/validate/username",
                        type: "get",
                        data: {
                          username: function(){
                                return $("#username").val();
                          }
                        }
                   }
              },
              email: {
                required: true,
                email: true,
                remote: {
                  url: "/"+SITE_BASE_LANG+"/validate/email",
                  type: "get",
                  data: {
                    email: function() {
                      return $("#email").val();
                    }
                  }
                }
              },
              repemail:{
                  equalTo: "#email"
              }


            },
            messages:{
                email:{
                      required: t("errore-email-formato"),
                      remote: t("messaggio-errore-email-formato")
                },
                username:{
                    required: t("username richiesto"),
                    remote: t("Username esistente")
                }
            }
    });
  
  
   particlesJS('wib_login',
  
  {
    "particles": {
      "number": {
        "value": 60,
        "density": {
          "enable": true,
          "value_area": 600
        }
      },
      "color": {
        "value": "#3098d8"
      },
      "shape": {
        "type": "circle",
        "stroke": {
          "width": 1,
          "color": "#ffffff"
        },
        "polygon": {
          "nb_sides": 5
        },
        "image": {
          "src": "http://app.winnub.com/public/img/logo.svg",
          "width": 100,
          "height": 100
        }
      },
      "opacity": {
        "value": 0.5,
        "random": false,
        "anim": {
          "enable": false,
          "speed": 1,
          "opacity_min": 0.1,
          "sync": false
        }
      },
      "size": {
        "value": 8,
        "random": true,
        "anim": {
          "enable": false,
          "speed": 10,
          "size_min": 0.4,
          "sync": false
        }
      },
      "line_linked": {
        "enable": true,
        "distance": 150,
        "color": "#ffffff",
        "opacity": 0.4,
        "width": 1
      },
      "move": {
        "enable": true,
        "speed": 6,
        "direction": "none",
        "random": true,
        "straight": false,
        "out_mode": "out",
        "attract": {
          "enable": false,
          "rotateX": 600,
          "rotateY": 1200
        }
      }
    },
    "interactivity": {
      "detect_on": "canvas",
      "events": {
        "onhover": {
          "enable": true,
          "mode": "repulse"
        },
        "onclick": {
          "enable": false,
          "mode": "push"
        },
        "resize": true
      },
      "modes": {
        "grab": {
          "distance": 400,
          "line_linked": {
            "opacity": 1
          }
        },
        "bubble": {
          "distance": 400,
          "size": 40,
          "duration": 2,
          "opacity": 8,
          "speed": 3
        },
        "repulse": {
          "distance": 200
        },
        "push": {
          "particles_nb": 1
        },
        "remove": {
          "particles_nb": 2
        }
      }
    },
    "retina_detect": true,
    "config_demo": {
      "hide_card": true,
      "background_color": "#b61924",
      "background_image": "",
      "background_position": "50% 50%",
      "background_repeat": "no-repeat",
      "background_size": "cover"
    }
  }

);
    
    
});