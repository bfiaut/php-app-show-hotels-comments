<?php $this->load->view('header'); ?>

<div id="wrapper">


	<div name="login-form" class="login-form">

	<!--HEADER-->
    <div class="header">

    <span id="comments_title"><h1>Commentaires</h1></span>
    <span id="hotels_title"><h1>Hotels</h1></span>

    </div>
    <!--END HEADER-->
	
	<!--CONTENT-->
    <div class="content">
	    <div id="button_new_post_div"><button id="button_new_post" type="button" class="button">Ajouter un commentaire !</button></div><br/>
    	<div id="add_new_post">
			<input id="form-username" name="username" type="text" class="input username" value="Username" onfocus="this.value=''" /><br>
	    	<input id="form-content" name="content" type="textarea" class="input username" value="Comment" onfocus="this.value=''" /><br>
	    	<button id="button_create_post" type="button" class="button">Envoyer !</button>
    	</div>
    	<br />

        <div id="hotels">
            <ul id="ul_hotels">
            </ul>
        </div>

        <div id="comments">
        <h3 id="hotel_title_name"></h3>
        <button id="buttonBackToHotelList" type="button" class="button">Retour à la liste des hôtels !</button>
            <ul id="ul_comments">
            </ul>
        </div>

        <!-- Modal -->

        <!-- Modals -->
        <div class='modal hide fade' id='infos'>
            <div class='modal-header'> <a class='close' data-dismiss='modal'>×</a>
                <h3>Edition d'un commentaire</h3>
            </div>
            <div class='modal-body'>
                <form id='comment-edit-form' href='/index.php/services/editComment' class='form-horizontal' action='#'>
                    <div class='form-row row-fluid'>
                        <div class='span12'>
                            <div class='row-fluid'>
                                <label class='form-label span4' for='tooltip'>Commentaire : </label>
                                <input value='' name='title' class='span8 tip text comment-edit-value' id='tooltipInput' type='text' oldtitle='Commentaire' title='Commentaire' aria-describedby='ui-tooltip-7'>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class='modal-footer'>
                <button class='btn' data-dismiss='modal' aria-hidden='true'>Annuler</button>
                <button class='btn btn-primary' id='comment-edit-send'>Envoyer !</button>
            </div>
        </div>

    </div>
    <!--END CONTENT-->
    
    <!--FOOTER-->
    <div class="footer">
        Copyright (c) 2013 - Bastien Fiaut - Fidbacks
    </div>
    <!--END FOOTER-->

	</div>

</div>