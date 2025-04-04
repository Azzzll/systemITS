document.addEventListener("DOMContentLoaded", () => {
    const deleteSelectedBtn = document.getElementById("deleteSelectedBtn");
    const selectAllCheckbox = document.getElementById("selectAll");
    const equipmentTableBody = document.getElementById("equipmentTableBody");
    const viewEditModal = new bootstrap.Modal(document.getElementById("viewEditModal"));
    const addEntryModal = new bootstrap.Modal(document.getElementById("viewEditModal")); // Используем то же модальное окно
    const editForm = document.getElementById("editForm");
    const addEntryBtn = document.getElementById("addEntryBtn");

    // Удаление выделенных записей
    deleteSelectedBtn.addEventListener("click", () => {
        const selectedCheckboxes = document.querySelectorAll(
            'input[type="checkbox"]:checked:not(#selectAll)'
        );

        if (selectedCheckboxes.length === 0) {
            alert("Выберите записи для удаления.");
            return;
        }

        if (confirm("Вы уверены, что хотите удалить выделенные записи?")) {
            selectedCheckboxes.forEach((checkbox) => {
                checkbox.closest("tr").remove();
            });
        }
    });

    // Выделение всех записей
    selectAllCheckbox.addEventListener("change", (event) => {
        const checkboxes = document.querySelectorAll(
            'input[type="checkbox"]:not(#selectAll)'
        );
        checkboxes.forEach((checkbox) => {
            checkbox.checked = event.target.checked;
        });
    });

    // Фильтрация данных
    const filters = {
        section: document.getElementById("filterSection"),
        type: document.getElementById("filterType"),
        locationDepartment: document.getElementById("filterLocationDepartment"),
    };

    Object.values(filters).forEach((filter) => {
        filter.addEventListener("change", applyFilters);
    });

    function applyFilters() {
        const rows = equipmentTableBody.querySelectorAll("tr");
        rows.forEach((row) => {
            const section = row.dataset.section;
            const type = row.dataset.type;
            const locationDepartment = row.dataset.locationDepartment;

            row.style.display =
                (filters.section.value === "" || filters.section.value === section) &&
                (filters.type.value === "" || filters.type.value === type) &&
                (filters.locationDepartment.value === "" || filters.locationDepartment.value === locationDepartment)
                    ? ""
                    : "none";
        });
    }

    // Функция для очистки полей формы
    function clearFormFields() {
        editForm.reset(); // Простой способ очистить все поля формы
    }

    // Открытие модального окна для создания новой записи
    addEntryBtn.addEventListener("click", () => {
        clearFormFields();
        viewEditModal._activeRow = null; // Указываем, что это новая запись
        addEntryModal.show();
    });

    // Открытие модального окна при нажатии на строку
    equipmentTableBody.addEventListener("click", (event) => {
        const target = event.target;
        const row = target.closest("tr");
        
        // Игнорируем клики по чекбоксам
        if (target.matches('input[type="checkbox"]')) return;

        if (row) {
            // Заполняем модальное окно данными из строки
            document.getElementById('editSection').value = row.cells[2].textContent;
            document.getElementById('editType').value = row.cells[3].textContent;
            document.getElementById('editDescription').value = row.cells[4].textContent;
            document.getElementById('editInventoryNumber').value = row.cells[5].textContent;
            document.getElementById('editSerialNumber').value = row.cells[6].textContent;
            document.getElementById('editLocationDepartment').value = row.cells[7].textContent;
            document.getElementById('editLocationAudience').value = row.cells[8].textContent;
            document.getElementById('editLocationWorkplace').value = row.cells[9].textContent;

            // Сохраняем ссылку на редактируемую строку
            viewEditModal._activeRow = row;
            viewEditModal.show();
        }
    });

    // Сохранение изменений (и для новой записи, и для редактирования)
    document.getElementById('saveChangesBtn').addEventListener('click', () => {
        const row = viewEditModal._activeRow;

        // Собираем данные из формы
        const section = document.getElementById('editSection').value;
        const type = document.getElementById('editType').value;
        const description = document.getElementById('editDescription').value;
        const inventoryNumber = document.getElementById('editInventoryNumber').value;
        const serialNumber = document.getElementById('editSerialNumber').value;
        const locationDepartment = document.getElementById('editLocationDepartment').value;
        const locationAudience = document.getElementById('editLocationAudience').value;
        const locationWorkplace = document.getElementById('editLocationWorkplace').value;

        if (row) {
            // Редактирование существующей записи
            row.cells[2].textContent = section;
            row.cells[3].textContent = type;
            row.cells[4].textContent = description;
            row.cells[5].textContent = inventoryNumber;
            row.cells[6].textContent = serialNumber;
            row.cells[7].textContent = locationDepartment;
            row.cells[8].textContent = locationAudience;
            row.cells[9].textContent = locationWorkplace;

            row.dataset.section = section;
            row.dataset.type = type;
            row.dataset.locationDepartment = locationDepartment;

        } else {
            // Создание новой записи
            const newRow = document.createElement('tr');
            newRow.dataset.section = section;
            newRow.dataset.type = type;
            newRow.dataset.locationDepartment = locationDepartment;

            newRow.innerHTML = `
                <td><input type="checkbox"></td>
                <td></td>
                <td>${section}</td>
                <td>${type}</td>
                <td>${description}</td>
                <td>${inventoryNumber}</td>
                <td>${serialNumber}</td>
                <td>${locationDepartment}</td>
                <td>${locationAudience}</td>
                <td>${locationWorkplace}</td>`;

            equipmentTableBody.appendChild(newRow);
        }

        viewEditModal.hide();
        applyFilters(); // Обновляем фильтры после добавления/изменения
    });

    // Фильтрация
    function applyFilters() {
        const rows = equipmentTableBody.querySelectorAll("tr");
        rows.forEach(row => {
            const showRow =
                (filters.section.value === "" || row.dataset.section === filters.section.value) &&
                (filters.type.value === "" || row.dataset.type === filters.type.value) &&
                (filters.locationDepartment.value === "" || row.dataset.locationDepartment === filters.locationDepartment.value);

            row.style.display = showRow ? "" : "none";
        });
    }
});