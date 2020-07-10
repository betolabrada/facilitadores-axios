$(document).ready(function () {
  $('#search').on('keyup', function () {
    var value = $(this).val().toLowerCase()
    if (value === '') {
      document.getElementById('houdini').style.visibility = 'collapse'
    } else {
      document.getElementById('houdini').style.visibility = 'visible'
      $('#filter tr').filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      })
    }
  })
})
