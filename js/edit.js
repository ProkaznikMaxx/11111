// edit.js
function loadGrades() {
    // Загрузка оценок
    $("#infoContainer").load("load_grades.php");
}
// edit.js
$(document).ready(function () {
    // Ваши другие функции и код

    // Функция для динамической загрузки оценок
    function loadGrades() {
        // Отправляем запрос на сервер для получения оценок
        $.ajax({
            type: "GET",
            url: "load_grades.php",
            success: function (data) {
                // Обновляем содержимое контейнера с оценками
                $("#gradesContainer").html(data);
            },
            error: function () {
                alert("Ошибка при загрузке оценок.");
            }
        });
    }

    // Другие функции и код
});

function loadSubjects() {
    // Загрузка предметов
    $("#infoContainer").load("load_subjects.php");
}

function loadStudents() {
    // Загрузка студентов
    $("#infoContainer").load("load_students.php");
}

function loadEvents() {
    // Загрузка мероприятий
    $("#infoContainer").load("load_events.php");
}
