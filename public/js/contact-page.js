//submitting the form
$(document).ready(function() {
    $('.deleteContact').on('click', deleteUser);
    $('#contact-form').submit((event) => {
        event.preventDefault();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: "/submit-form",
            data: $('form#contact-form').serialize(),
            success: (data) => {
                alert('Added successfully. the data will be shown shortly.');
                window.location.replace('/form');
                return false;
            },
            fail: (data) => {
                alert(data);
                window.location.replace('/form');
                return false;
            }
        });
    });
});

//deleting users
function deleteUser() {
  var confirmation = confirm('Are you sure?');

  if(confirmation) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'DELETE',
        url: `/delete-record/${$(this).data('id')}`
    }).done((response) => {
      window.location.replace('/form');
      return false;
    });

    window.location.replace('/form');
    return false;
  } else {
    return false;
  }
};
