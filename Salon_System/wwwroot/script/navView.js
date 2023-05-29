//Scripts to navigate to view onClick

function viewClient(clientId) {
    window.location.href = "/Client/Details/" + clientId;
}

function updateClient(clientId) {
    window.location.href = "/Client/Update/" + clientId;
}

function viewEmployee(employeeId) {
    window.location.href = "/Employee/Details/" + employeeId;
}

function updateEmployee(employeeId) {
    window.location.href = "/Employee/Update/" + employeeId;
}

function viewService(serviceId) {
    window.location.href = "/Service/Details/" + serviceId;
}

function updateService(serviceId) {
    window.location.href = "/Service/Update/" + serviceId;
}