window.addEventListener("DOMContentLoaded", function () {

  const loading = Swal.fire({
    title: 'Loading data.. Please wait!',
    timerProgressBar: true,
    onBeforeOpen: () => {
      Swal.showLoading()
    },
    allowOutsideClick: () => !Swal.isLoading()
  })

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  window.showRooms = function showRooms(type) {
    var allRooms = scheduler.serverList("rooms");
    var visibleRooms;
    if (type == 'all') {
      visibleRooms = allRooms.slice();
    } else {
      visibleRooms = allRooms
        .filter(function (room) {
          return room.type == type;
        });
    }

    scheduler.updateCollection("visibleRooms", visibleRooms);
  };

  window.bookingRequest = function bookingRequest(method, data, message, lastMsg) {
    Swal.fire({
      title: `${message} data.. Please wait!`,
      timerProgressBar: true,
      onBeforeOpen: () => {
        Swal.showLoading()
      },
      allowOutsideClick: false
    })

    $.ajax({
      url: '/api/bookings',
      method,
      data,
      dataType: 'json',
      success: function (data) {
        console.log(data);
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: `The booking has been ${lastMsg}!`,
          showConfirmButton: false,
          timer: 1500
        })
      },
      error: function (err) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: err,
          showConfirmButton: false,
          timer: 1500
        })
        console.log(err);
      }
    })
  }

  scheduler.locale.labels.section_name = 'Name';
  scheduler.locale.labels.section_contact = 'Contact #';
  scheduler.locale.labels.section_guests = 'No. of Guests';
  scheduler.locale.labels.section_room = 'Room';
  scheduler.locale.labels.section_concerns = 'Requests';
  scheduler.locale.labels.section_status = 'Status';
  scheduler.locale.labels.section_is_paid = 'Paid';
  scheduler.locale.labels.section_time = 'Time';
  scheduler.locale.labels.icon_cancel = 'Close';
  scheduler.locale.labels.icon_delete = 'Cancel Event';
  scheduler.locale.labels["checkout_button"] = "Checkout";

  scheduler.config.details_on_create = true;
  scheduler.config.details_on_dblclick = true;
  scheduler.config.buttons_left = ["dhx_save_btn", "dhx_cancel_btn"];
  scheduler.config.buttons_right = ["dhx_delete_btn", "checkout_button"];

  //===============
  //Configuration
  //===============

  scheduler.serverList("roomTypes");
  scheduler.serverList("rooms");

  scheduler.createTimelineView({
    name: "timeline",
    x_unit: "day",
    x_date: "%j",
    x_step: 1,
    x_size: 31,
    // section_autoheight: true,
    y_unit: scheduler.serverList("visibleRooms"),
    y_property: "room",
    render: "bar",
    round_position: true,
    event_dy: "full",
    dy: 60,
    second_scale: {
      x_unit: "month",
      x_date: "%F, %Y",
    },
  });

  scheduler.attachEvent("onBeforeViewChange", function (old_mode, old_date, mode, date) {
    var year = date.getFullYear();
    var month = (date.getMonth() + 1);
    var d = new Date(year, month, 0);
    var daysInMonth = d.getDate();
    var timeline = scheduler.getView('timeline');
    timeline.x_size = daysInMonth;
    return true;
  });

  scheduler.date.timeline_start = scheduler.date.month_start;

  scheduler.date.add_timeline = function (date, step) {
    if (step > 0) {
      step = 1;
    } else if (step < 0) {
      step = -1;
    }
    return scheduler.date.add(date, step, "month")
  };

  scheduler.addMarkedTimespan({
    days: [0, 6],
    zones: "fullday",
    css: "timeline_weekend"
  });


  scheduler.config.lightbox.sections = [
    { map_to: "name", name: "name", type: "textarea", height: 25 },
    { map_to: "contact", name: "contact", type: "textarea", height: 25 },
    { map_to: "guests", name: "guests", type: "textarea", height: 25 },
    { map_to: "room", name: "room", type: "select", options: scheduler.serverList("visibleRooms") },
    { map_to: "concerns", name: "concerns", type: "textarea", height: 25 },
    {
      map_to: "status", name: "status", type: "radio", options: [
        { key: 1, label: 'Walk-in' },
        { key: 2, label: 'Guaranteed' },
        { key: 3, label: 'Checked-in ' }
      ]
    },
    { map_to: "is_paid", name: "is_paid", type: "checkbox", checked_value: true, unchecked_value: false },
    { map_to: "time", name: "time", type: "calendar_time" }
  ];

  scheduler.attachEvent('onBeforeLightBox', function (event_id) {
    var ev = scheduler.getEvent(event_id);
    if (ev.status === 4) {
      ev.readonly = true;
      scheduler.config.buttons_left = ["dhx_cancel_btn"];
      scheduler.config.buttons_right = [];
    }
    return true;
  });

  scheduler.attachEvent('onLightBox', function (event_id) {
    var box = scheduler.getLightbox();
    box.style.top = "30px";
    box.style.left = "290px";
  })

  scheduler.attachEvent("onLightboxButton", function (button_id) {
    if (button_id == "checkout_button") {
      var event_id = scheduler.getState().lightbox_id;
      var ev = scheduler.getEvent(event_id);
      var rentalDays = getDifference(ev.start_date, ev.end_date);
      var toPay = Math.floor(getRoomType(getRoom(ev.room).type).rate * getDifference(ev.start_date, ev.end_date));
      Swal.fire({
        html:
          `<table class="table" style="width: 100%;">
            <tbody>
              <tr>
                <th class="font-weight-bolder th">Room Type:</th>
                <td class="td">${getRoomType(getRoom(ev.room).type).label}</td>
              </tr>
              <tr>
                <th class="font-weight-bolder th">Rate:</th>
                <td class="td">₱ ${getRoomType(getRoom(ev.room).type).rate}</td>
              </tr>
              <tr>
                <th class="font-weight-bolder th">Rental Days:</th>
                <td class="td">${rentalDays} Days</td>
              </tr>
              <tr>
                <th class="font-weight-bolder th">Total Payment:</th>
                <td class="td">₱ ${toPay}</td>
              </tr>
            </tbody>
          </table>`,
        confirmButtonText: 'Confirm Check-Out'
      }).then(result => {
        if (result.value) {
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to undo this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
          }).then(res => {
            if (res.value) {
              scheduler.callEvent("onCheckOut", [event_id])
            }
            else {
              this.close();
            }
          })
        }
      })
    }
  });

  scheduler.attachEvent('onEventCreated', function (event_id) {
    var ev = scheduler.getEvent(event_id);
    ev.name = 'New Reservation';
    ev.contact = '';
    ev.guests = 1;
    ev.status = 1;
    ev.is_paid = false;
  });

  scheduler.attachEvent('onEventAdded', function (event_id) {
    const ev = scheduler.getEvent(event_id);
    // console.log(ev);
    const data = {
      id: ev.id,
      room: ev.room,
      name: ev.name,
      contact: ev.contact,
      guests: ev.guests,
      concerns: ev.concerns,
      status: ev.status,
      is_paid: ev.is_paid,
      start_date: ev.start_date.toISOString().split('T')[0] + ' ' + ev.start_date.toTimeString().split(' ')[0],
      end_date: ev.end_date.toISOString().split('T')[0] + ' ' + ev.end_date.toTimeString().split(' ')[0],
    }
    bookingRequest("POST", data, "Adding", "added");
  })

  scheduler.attachEvent('onEventChanged', function (event_id) {
    const ev = scheduler.getEvent(event_id);

    const data = {
      id: ev.id,
      room: ev.room,
      name: ev.name,
      contact: ev.contact,
      guests: ev.guests,
      concerns: ev.concerns,
      status: ev.status,
      is_paid: ev.is_paid,
      start_date: ev.start_date.toISOString().split('T')[0] + ' ' + ev.start_date.toTimeString().split(' ')[0],
      end_date: ev.end_date.toISOString().split('T')[0] + ' ' + ev.end_date.toTimeString().split(' ')[0],
    }
    bookingRequest("PUT", data, "Updating", "updated");
  });

  scheduler.attachEvent("onEventDeleted", function (event_id) {
    if (scheduler.getState().new_event) {
      Swal.fire({
        icon: 'warning',
        title: 'Warning',
        text: `The booking has not been saved!`,
        showConfirmButton: false,
        timer: 1500
      })
      return;
    }

    var data = {
      id: event_id
    }
    bookingRequest("DELETE", data, "Deleting", "deleted");
  });

  scheduler.attachEvent("onCheckOut", function (event_id) {
    var ev = scheduler.getEvent(event_id);


    const data = {
      id: ev.id,
      type: getRoomType(getRoom(ev.room).type).label,
      guests: ev.guests,
      status: 4,
      is_paid: 1,
      payment: Math.floor(getRoomType(getRoom(ev.room).type).rate * getDifference(ev.start_date, ev.end_date)),
      start_date: ev.start_date.toISOString().split('T')[0]
    }

    console.log(data);

    $.ajax({
      method: 'PUT',
      url: '/api/booking/checkout',
      data,
      dataType: 'json',
      success: function (data) {
        if (data === true) {
          Swal.fire({
            icon: 'error',
            title: 'Check-out failed!',
            text: 'You cannot check-out future reservations.'
          })
        }
        else {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: `The booking has been checked-out!`,
            showConfirmButton: false,
            timer: 1500
          })
          window.location.reload();
        }
      },
      error: function (err) {
        console.log(err);
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong. Please contact your IT Administrator.',
          showConfirmButton: false,
          timer: 1500
        })
      }
    })

    // scheduler.endLightbox(false, $('.dhx_cal_light').get(0));
  });

  scheduler.attachEvent("onParse", function () {
    showRooms("all");

    var roomSelect = document.querySelector("#room_filter");
    var types = scheduler.serverList("roomTypes");
    var typeElements = ["<option value='all'>All</option>"];
    types.forEach(function (type) {
      typeElements.push("<option value='" + type.key + "'>" + type.label + "</option>");
    });
    roomSelect.innerHTML = typeElements.join("")
  });

  var headerHTML =
    "<div class='timeline_item_cell'>Room Number</div>" +
    "<div class='timeline_item_separator'></div>" +
    "<div class='timeline_item_cell'>Type</div>";

  scheduler.locale.labels.timeline_scale_header = headerHTML;

  scheduler.attachEvent("onTemplatesReady", function () {

    window.findInArray = function findInArray(array, key) {
      for (var i = 0; i < array.length; i++) {
        if (key == array[i].key)
          return array[i];
      }
      return null;
    }

    window.getRoomType = function getRoomType(key) {
      return findInArray(scheduler.serverList("roomTypes"), key);
    }

    window.getRoom = function getRoom(key) {
      return findInArray(scheduler.serverList("rooms"), key);
    }

    scheduler.templates.timeline_scale_label = function (key, label, section) {
      return ["<div class='timeline_item_separator'></div>",
        "<div class='timeline_item_cell'>" + label + "</div>",
        "<div class='timeline_item_separator'></div>",
        "<div class='timeline_item_cell'>" + getRoomType(section.type).label + "</div>"].join("");
    };

    scheduler.templates.event_class = function (start, end, event) {
      return "event_" + (event.status || "");
    };

    window.getBookingStatus = function getBookingStatus(key) {
      var bookingStatus = findInArray(scheduler.serverList("bookingStatuses"), key);
      return !bookingStatus ? '' : bookingStatus.label;
    }

    window.getPaidStatus = function getPaidStatus(isPaid) {
      return isPaid ? "paid" : "not paid";
    }

    var eventDateFormat = scheduler.date.date_to_str("%d %M %Y");
    scheduler.templates.event_bar_text = function (start, end, event) {
      var paidStatus = getPaidStatus(event.is_paid);
      var startDate = eventDateFormat(event.start_date);
      var endDate = eventDateFormat(event.end_date);
      return [event.name + "<br />",
      startDate + " - " + endDate,
      "<div class='booking_status booking-option'>" + getBookingStatus(event.status) + "</div>",
      "<div class='booking_paid booking-option'>" + paidStatus + "</div>"].join("");
    };

    window.getDifference = function getDifference(start, end) {
      var timeDiff = end.getTime() - start.getTime();
      return Math.floor(timeDiff / (1000 * 3600 * 24)) + 1;
    }

    scheduler.templates.tooltip_text = function (start, end, event) {
      var room = getRoom(event.room) || { label: "" };
      var toPay = Math.floor(getRoomType(getRoom(event.room).type).rate * getDifference(start, end));
      var isPaid = ['No', 'Yes'];

      var html = [];
      html.push("Booked By: <b>" + event.name + "</b>");
      html.push("Guests: <b>" + event.guests + "</b>");
      html.push("Rate: <b>₱ " + getRoomType(getRoom(event.room).type).rate + "</b>");
      html.push("To Pay: <b>₱ " + toPay + "</b>");
      html.push("Check-in: <b>" + eventDateFormat(start) + "</b>");
      html.push("Check-out: <b>" + eventDateFormat(end) + "</b>");
      html.push("Status: <b>" + getBookingStatus(event.status) + "</b>");
      html.push("Is Paid: <b>" + isPaid[event.is_paid] + "</b>");
      html.push("Special Concerns: <b>" + event.concerns + "</b>");
      return html.join("<br>")
    };

    scheduler.templates.lightbox_header = function (start, end, ev) {
      var formatFunc = scheduler.date.date_to_str('%d.%m.%Y');
      return formatFunc(start) + " - " + formatFunc(end);
    };

  });

  scheduler.attachEvent("onEventCollision", function (ev, evs) {
    for (var i = 0; i < evs.length; i++) {
      if (ev.room != evs[i].room) continue;
      dhtmlx.message({
        type: "error",
        text: "There is a room already booked for this date."
      });
    }
    return true;
  });


  scheduler.init('scheduler_here', new Date(), "timeline");
  $.ajax({
    url: '/api/bookings',
    method: "GET",
    dataType: 'json',
    success: function (values) {
      scheduler.parse({
        data: values.data,
        collections: values.collections
      })
      loading.close();
    },
    error: function (err) {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Something wen\'t wrong. Try refreshing this page.'
      })
    },
  })
});
