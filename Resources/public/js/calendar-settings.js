$(function() {
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();

	$('#calendar-holder').fullCalendar(
			{
				header : {
					left : 'prev, next',
					center : 'title',
					right : 'month,agendaWeek,agendaDay,'
				},
				allDaySlot : false,
				droppable : true,
				drop : function(date, allDay, jsEvent, ui) {
					var element = this;
					$.ajax({
						url : Routing.generate('fullcalendar_event_dropped'),
						data : {
							date : date,
							id : this.id,
							installationId: $(this).prop('installationId')
						},
						success : function(data, textStatus, jqXHR) {
							$('#calendar-holder').fullCalendar('renderEvent',
									data, true);
							$(element).remove();
						}
					});
				},
				lazyFetching : true,
				weekNumbers : true,
				timeFormat : {
					// for agendaWeek and agendaDay
					agenda : 'h:mmt', // 5:00 - 6:30

					// for all other views
					'' : 'h:mmt' // 7p
				},
				eventSources : [ {
					url : Routing.generate('fullcalendar_loader'),
					type : 'POST',
					error : function() {
						// alert('There was an error while fetching Google
						// Calendar!');
					}
				} ],
				eventClick : function(event, element) {
					console.log('click');
				},
				editable : true,
				eventDrop : function(event, dayDelta, minuteDelta, allDay,
						revertFunc, jsEvent, ui, view) {
					$.ajax({
						url : Routing.generate('fullcalendar_event_dragged'),
						data : event
					});
				}
			});
});
