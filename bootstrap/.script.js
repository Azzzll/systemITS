const data = {
    myRequests: [
    ],
    unassigned: [
        { id: 1, topic: "Неисправность печатной техники", applicant: "Сидоров С.С.", date: "2025-03-09T12:00", status: "Новая", priority: "Срочно", executor: "" },
        { id: 2, topic: "Электрика / освещение", applicant: "Сидоров С.С.", date: "2025-03-10T12:00", status: "Новая", priority: "Срочно", executor: "" }
    ],
    archive: [
        { id: 1, topic: "Телефония", applicant: "Кузнецов К.К.", date: "2025-02-28T16:00", status: "Решена", priority: "Низкая", executor: "Иванова А.А." }
    ]
};

const headers = [
    { key: 'id', label: '№' },
    { key: 'topic', label: 'Тема' },
    { key: 'applicant', label: 'Заявитель' },
    { key: 'date', label: 'Дата и время' },
    { key: 'status', label: 'Статус' },
    { key: 'priority', label: 'Важность' },
    { key: 'executor', label: 'Исполнитель' }
];

function renderTableHeader() {
    const headerRow = headers.map(header => {
        if (header.key === 'topic') {
            return `<th onclick="filterColumn('${header.key}')">
                ${header.label} 
                <select id="filterTopic" class="form-select form-select-sm">
                    <option value="">Все</option>
                    <option value="Проблемы доступа">Проблемы доступа</option>
                    <option value="Неисправность программного обеспечения">Неисправность ПО</option>
                    <option value="Неисправность АРМ">Неисправность АРМ</option>
                    <option value="Неисправность печатной техники">Неисправность печати</option>
                    <option value="Электрика / освещение">Электрика</option>
                    <option value="Телефония">Телефония</option>
                </select>
            </th>`;
        } else if (header.key === 'date') {
            return `<th onclick="filterColumn('${header.key}')">
                ${header.label} 
                <input type="text" id="filterDate" class="form-select form-select-sm" placeholder="Дата">
            </th>`;
        } else if (header.key === 'status') {
            return `<th onclick="filterColumn('${header.key}')">
                ${header.label} 
                <select id="filterStatus" class="form-select form-select-sm">
                    <option value="">Все</option>
                    <option value="Новая">Новая</option>
                    <option value="Открыта">Открыта</option>
                    <option value="В работе">В работе</option>
                    <option value="На подтверждение">На подтверждение</option>
                    <option value="На отклонение">На отклонение</option>
                    <option value="Решена">Решена</option>
                    <option value="Отклонена">Отклонена</option>
                </select>
            </th>`;
        } else if (header.key === 'priority') {
            return `<th onclick="filterColumn('${header.key}')">
                ${header.label} 
                <select id="filterPriority" class="form-select form-select-sm">
                    <option value="">Все</option>
                    <option value="Низкая">Низкая</option>
                    <option value="Средняя">Средняя</option>
                    <option value="Срочно">Срочно</option>
                </select>
            </th>`;
        } else if (header.key === 'executor') {
            return `<th onclick="filterColumn('${header.key}')">
                ${header.label} 
                <select id="filterExecutor" class="form-select form-select-sm">
                    <option value="">Все</option>
                    <option value="Иванов И.">Иванов И.</option>
                    <option value="Петров П.">Петров П.</option>
                    <option value="Носов Н.">Носов Н.</option>
                </select>
            </th>`;
        } else {
            return `<th>${header.label}</th>`;
        }
    }).join("");

    // document.getElementById("tableHeader").innerHTML = `<tr>${headerRow}</tr>`;

    // Инициализация календаря для даты
    flatpickr("#filterDate", {
        dateFormat: "Y-m-d",
        locale: "ru"
    });

    // Добавление обработчиков для фильтров
    document.getElementById("filterTopic").addEventListener("change", applyFilters);
    document.getElementById("filterDate").addEventListener("change", applyFilters);
    document.getElementById("filterStatus").addEventListener("change", applyFilters);
    document.getElementById("filterPriority").addEventListener("change", applyFilters);
    document.getElementById("filterExecutor").addEventListener("change", applyFilters);
}

function renderTableBody(section) {
    const rows = data[section].map(row => {
        const date = new Date(row.date);
        const formattedDate = `${date.toLocaleDateString()} ${date.toLocaleTimeString()}`;

        return `
            <tr onclick="showRequestModal(${row.id}, '${section}')">
                ${headers.map(header => {
                    if (header.key === 'date') {
                        return `<td>${formattedDate}</td>`;
                    } else {
                        return `<td>${row[header.key]}</td>`;
                    }
                }).join("")}
            </tr>`;
    }).join("");

    document.getElementById("tableBody").innerHTML = rows || "<tr><td colspan='7'>Нет данных</td></tr>";
}

function changeSection(section) {
    document.querySelectorAll(".sidebar .btn").forEach(btn => btn.classList.remove("active"));
    
    switch (section) {
        case 'myRequests':
            document.querySelector(".sidebar .btn:nth-child(3)").classList.add("active");
            break;
        case 'unassigned':
            document.querySelector(".sidebar .btn:nth-child(2)").classList.add("active");
            break;
        case 'archive':
            document.querySelector(".sidebar .btn:nth-child(4)").classList.add("active");
            break;
        default:
            break;
    }

    renderTableBody(section);
}

function navigate(page) {
    window.location.href = page;
}

function applyFilters() {
    const section = document.querySelector(".sidebar .btn.active").textContent.trim().toLowerCase();
    const filterTopic = document.getElementById("filterTopic").value;
    const filterDate = document.getElementById("filterDate").value;
    const filterStatus = document.getElementById("filterStatus").value;
    const filterPriority = document.getElementById("filterPriority").value;
    const filterExecutor = document.getElementById("filterExecutor").value;

    const filteredData = data[section].filter(row => {
        return (
            (filterTopic === "" || row.topic === filterTopic) &&
            (filterDate === "" || new Date(row.date).toLocaleDateString() === new Date(filterDate).toLocaleDateString()) &&
            (filterStatus === "" || row.status === filterStatus) &&
            (filterPriority === "" || row.priority === filterPriority) &&
            (filterExecutor === "" || row.executor === filterExecutor)
        );
    });

    renderFilteredTable(filteredData);
}

function renderFilteredTable(filteredData) {
    if (filteredData.length > 0) {
        const rows = filteredData.map(row => {
            const date = new Date(row.date);
            const formattedDate = `${date.toLocaleDateString()} ${date.toLocaleTimeString()}`;

            return `
                <tr onclick="showRequestModal(${row.id}, 'filtered')">
                    ${headers.map(header => {
                        if (header.key === 'date') {
                            return `<td>${formattedDate}</td>`;
                        } else {
                            return `<td>${row[header.key]}</td>`;
                        }
                    }).join("")}
                </tr>`;
        }).join("");

        document.getElementById("tableBody").innerHTML = rows;
    } else {
        document.getElementById("tableBody").innerHTML = "<tr><td colspan='7'>Нет данных для выбранного фильтра.</td></tr>";
    }
}

function showRequestModal(id, section) {
    const request = data[section].find(row => row.id === id);
    if (request) {
        document.getElementById("requestId").value = request.id;
        document.getElementById("requestTopic").value = request.topic;
        document.getElementById("requestApplicant").value = request.applicant;
        document.getElementById("requestDate").value = new Date(request.date).toLocaleString();
        document.getElementById("requestStatus").value = request.status;
        document.getElementById("requestPriority").value = request.priority;
        document.getElementById("requestDescription").value = "Описание заявки"; // Добавьте реальное описание
        document.getElementById("requestAuditorium").value = "Аудитория"; // Добавьте реальную аудиторию

        const modal = new bootstrap.Modal(document.getElementById('requestModal'));
        modal.show();
    }
}

document.addEventListener("DOMContentLoaded", () => {
    renderTableHeader();
    renderTableBody('myRequests');
});