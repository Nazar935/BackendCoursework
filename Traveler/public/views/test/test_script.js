// Инициализация Sortable.js
Sortable.create(document.getElementById('sortable-list'), {
    handle: '.drag-handle', // Перетаскивание возможно только за элементы с этим классом
    animation: 1000, // Анимация при перетаскивании
    ghostClass: 'sortable-ghost' // Класс для перемещаемого элемента
});
