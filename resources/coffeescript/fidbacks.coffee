$( ->

	$("#add_new_post").hide()
	$("#button_new_post_div").hide()
	$("#comments_title").hide()
	$("#buttonBackToHotelList").hide()

	$("#button_new_post").click( ->
		$("#add_new_post").show()
	)

	$("#buttonBackToHotelList").click( ->
		#window.hotel_focus = null
		$("#comments").hide()
		$("#hotels").show()
		$("#add_new_post_div").hide()
		$("#button_new_post_div").hide()
		$("#comments_title").hide()
		$("#hotels_title").show()
	)

	$("#button_create_post").click( -> 
		username = $("#form-username").first()[0].value
		content = $("#form-content").first()[0].value
		hotel_id = window.hotel_focus
		$.ajax '/index.php/services/createComment', 
			type:'POST'
			dataType:'json'
			data: {'author': username, 'content': content, 'hotel_id': hotel_id}
			error: (jqXHR, textStatus, errorThrown) ->
				alert textStatus
			success: (data, textStatus, jqXHR) ->
				alert "Votre commentaire a bien été enregistré !"
				$("#add_new_post").hide()

	)

	$("#comment-edit-send").click -> 
		new_value = {content: $("#comment-edit-form input").first().val()}
		$.post $("#comment-edit-form").attr('action'), new_value, (res) ->
			myHotel = null
			id = $("#comment-edit-form").data('commentid')
			for hotel in window.list_instance.hotels
				if hotel.id == hotel_focus
					for comment in hotel.commentList.comments
						if comment.id == id
							comment.content = new_value.content
							break
			$(".content-#{id}").html(new_value.content)
			$("#infos").modal('hide')
		, "json"
)

class window.HotelList
	constructor: ->
		@hotels = []
		@getHotels()
		setInterval(=>
			@updateHotelListFromId()
		, 5000)
	getHotels: ->
		klass = @
		$.getJSON("/index.php/services/getHotels", (res) ->
			$.each res, (elem) ->
				hotel = new Hotel @
				klass.hotels.push hotel
				hotel.show()
				hotel.bind()
		)
	updateHotelListFromId: ->
		klass = @
		if @hotels.length > 0
			id = @hotels[0].id
			$.ajaxSetup({
				async: false
			});
			$.getJSON("/index.php/services/getHotelsFromId/#{id}", (res) ->
				newHotels = []
				#Show new hotels
				$.each res, (elem) ->
					hotel = new Hotel @
					newHotels.push hotel
					hotel.top()
					hotel.bind()
					""
				klass.hotels = newHotels.concat klass.hotels
			)

class window.CommentList
	constructor: (hotel_id) ->
		@hotel_id = hotel_id
		@comments = []
		setInterval(=>
			@updateCommentListForHotel()
		, 5000)
	getCommentsForHotel: ->
		klass = @
		$.ajaxSetup({
        async: false
    });
		$.getJSON("/index.php/services/getCommentsForHotel/#{@.hotel_id}", (res) ->
			$.each res, (elem) ->
				comment = new Comment @
				klass.comments.push comment
				comment.bind()
			""
		)
	updateCommentListForHotel: ->
		klass = @
		if @comments.length > 0
			id = @comments[0].id
			$.ajaxSetup({
				async: false
			});
			$.getJSON("/index.php/services/getCommentsFromId/#{hotel_focus}/#{id}", (res) ->      
				newComments = []
				#Show new comments
				$.each res, (elem) ->
					comment = new Comment @
					newComments.push comment
					comment.top()
					comment.bind()
					""
				klass.comments = newComments.concat klass.comments
			)
	show: ->
		klass = @
		$("#hotels").hide()
		$("#comments").show()
		$("#comments_title").show()
		$("#hotels_title").hide()
		$("#button_new_post_div").show()
		$("#ul_comments").html("")
		for comment in @comments
			window.renderer_instance.showComment comment

class window.Hotel
	constructor: (json) ->
		@json = json
		@id = json.id
		@name = json.name
		@cityname = json.cityname
		@address = json.address
		@commentList = new window.CommentList @.id
	show: ->
		window.renderer_instance.showHotel @
	top: ->
		window.renderer_instance.topHotel @
	bind: ->
		klass = @
		elem = $("*[data-hotelid='#{@.id}']").find(".showCommentsForHotel").first().click(->
			$("#buttonBackToHotelList").show()
			html = klass.name+", "+klass.cityname
			$("#hotel_title_name").html(html)
#			comments = new window.CommentList klass.id
			window.hotel_focus = klass.id
			klass.commentList.getCommentsForHotel(klass.id)
			klass.commentList.show()
		)

class window.Comment
	constructor: (json) ->
		@json = json
		@id = json.id
		@author = json.author
		@creation_date = json.creation_date
		@content = json.content
		customDate = new Date(json.creation_date.date)
		day = if customDate.getDay() < 10 then "0" + customDate.getDay() else customDate.getDay()
		month = if customDate.getMonth() < 10 then "0" + customDate.getMonth() else customDate.getMonth()
		@final_date = day+"/"+month+"/"+customDate.getFullYear()	
	show: ->
		window.renderer_instance.showComment @
	top: ->
		window.renderer_instance.topComment @
	bind: ->
		klass = @
		$("*[data-commentid='#{@.id}']").first().hover(->
			fadeDiv = $(@).find("#modify_comment")
			if !fadeDiv.hasClass 'pinned'
				fadeDiv.show()
		, ->
			fadeDiv = $(@).find("#modify_comment")
			if !fadeDiv.hasClass 'pinned'
				fadeDiv.hide()
		)
		$("#edit-from-comment-list-#{klass.id}").live('click', -> 
			id = $(@).data("commentid")
			$('.comment-edit-value').val("#{klass.content}")
			$("#comment-edit-form").attr('action', "/index.php/services/updateComment/#{id}");
			$("#comment-edit-form").attr('data-commentid', id);
		)
		""	

class window.Renderer
	showHotel: (hotel) ->
		html = "<li data-hotelid='"+hotel.id+"'><div id='hotel_content'>"
		html += "<span id='hotel_name'>"+hotel.name+", </span>"
		html += "<span id='hotel_cityname'>"+hotel.cityname+"</span><br/>"
		html += "<span id='hotel_address'>"+hotel.address+"</span><br/>"
		html += "<a href='#' class='showCommentsForHotel'>Afficher les commentaires sur cet hôtel</a>";
		html += "</div></li>"
		$("#ul_hotels").append(html)
	topHotel: (hotel) ->
		html = "<li data-hotelid='"+hotel.id+"'><div id='hotel_content'>"
		html += "<span id='hotel_name'>"+hotel.name+", </span>"
		html += "<span id='hotel_cityname'>"+hotel.cityname+"</span><br/>"
		html += "<span id='hotel_address'>"+hotel.address+"</span><br/>"
		html += "<a href='#' class='showCommentsForHotel'>Afficher les commentaires sur cet hôtel</a>";
		html += "</div></li>"
		$("#ul_hotels").prepend(html)
	showComment: (comment) ->
		html = "<li data-commentid='"+comment.id+"'><div id='comment_content'>"
		html += "<span id='comment_author'>De : "+comment.author+"</span>"
		html += "<span id='comment_creation_date'> - Commentaire écrit le "+comment.final_date+"</span><br/>"
		html += "<span id='comment_text' class='content-#{comment.id}'>"+comment.content+"</span><br/>"
		# Start Modal
		html += "<a class='btn edit-from-comment-list' data-toggle='modal' href='#infos' id='edit-from-comment-list-#{comment.id}' data-commentid="+comment.id+"><img src='/resources/images/edit.png'></a>"
		# End modal
		html += "</div></li>"
		$("#ul_comments").append(html)
	topComment: (comment) ->
		html = "<li data-commentid='"+comment.id+"'><div id='comment_content'>"
		html += "<span id='comment_author'>De : "+comment.author+"</span>"
		html += "<span id='comment_creation_date'> - Commentaire écrit le "+comment.final_date+"</span><br/>"
		html += "<span id='comment_text' class='content-#{comment.id}'>"+comment.content+"</span><br/>"
		# Start modal
		html += "<a class='btn' data-toggle='modal' href='#infos' data-commentid="+comment.id+" id='edit-from-comment-list-#{comment.id}'><img src='/resources/images/edit.png'></a>"
		# End modal
		html += "</div></li>"
		$("#ul_comments").prepend(html)