/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$.fn.datepicker.defaults.format = "mm/dd/yyyy";

$(function(){
    
    $('.datepicker').datepicker({
        startDate: '-3d'
    });
});