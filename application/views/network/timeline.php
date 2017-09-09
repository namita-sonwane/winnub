<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


?>
        
    <ul class="timeline timeline-centered">

         <?php 

            if($timeline){

                foreach($timeline as $log){ ?>

                 <li class="timeline-item">
                    <div class="timeline-info">
                        <span><?=date("d/m/Y H:i",strtotime($log["data"]))?></span>
                    </div>
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3 class="timeline-title"><?=$log["azione"]?></h3>
                        <p><?=$log["descrizione"]?></p>
                    </div>
                </li>

                <?php }

            }

            /*
        ?>

        <li class="timeline-item">
            <div class="timeline-info">
                <span>March 12, 2016</span>
            </div>
            <div class="timeline-marker"></div>
            <div class="timeline-content">
                <h3 class="timeline-title">Event Title</h3>
                <p>Nullam vel sem. Nullam vel sem. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Donec vitae sapien ut libero venenatis faucibus. ullam dictum felis
                    eu pede mollis pretium. Pellentesque ut neque.</p>
            </div>
        </li>
        <li class="timeline-item">
            <div class="timeline-info">
                <span>March 23, 2016</span>
            </div>
            <div class="timeline-marker"></div>
            <div class="timeline-content">
                <h3 class="timeline-title">Event Title</h3>
                <p>Nullam vel sem. Nullam vel sem. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Donec vitae sapien ut libero venenatis faucibus. ullam dictum felis
                    eu pede mollis pretium. Pellentesque ut neque. </p>
            </div>
        </li>

        <li class="timeline-item period">
            <div class="timeline-info"></div>
            <div class="timeline-marker"></div>
            <div class="timeline-content">
                <h2 class="timeline-title">April 2016</h2>
            </div>
        </li>


        <li class="timeline-item">
            <div class="timeline-info">
                <span>April 02, 2016</span>
            </div>
            <div class="timeline-marker"></div>
            <div class="timeline-content">
                <h3 class="timeline-title">Event Title</h3>
                <p>Nullam vel sem. Nullam vel sem. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Donec vitae sapien ut libero venenatis faucibus. ullam dictum felis
                    eu pede mollis pretium. Pellentesque ut neque. </p>
            </div>
        </li>
        <li class="timeline-item">
            <div class="timeline-info">
                <span>April 28, 2016</span>
            </div>
            <div class="timeline-marker"></div>
            <div class="timeline-content">
                <h3 class="timeline-title">Event Title</h3>
                <p>Nullam vel sem. Nullam vel sem. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Donec vitae sapien ut libero venenatis faucibus. ullam dictum felis
                    eu pede mollis pretium. Pellentesque ut neque. </p>
            </div>
        </li>
             * 
             * 
             */?>
    </ul>
