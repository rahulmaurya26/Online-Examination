const userform = document.getElementById('user_id');
const first_form = document.getElementById('first_form');
const adminform = document.getElementById('admin_id');
const second_form = document.getElementById('second_form');
first_form.addEventListener('click', function() {
    userform.style.display = 'none';
    adminform.style.display = 'flex';
});
second_form.addEventListener('click', function() {
    userform.style.display = 'flex';
    adminform.style.display = 'none';
});
