document.addEventListener("DOMContentLoaded", () => {
    loadUsuarios();

    document.getElementById("userForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const userId = document.getElementById("userId").value;
        if (userId) {
            updateUser(userId);
        } else {
            addUser();
        }
    });
});

function loadUsuarios() {
    fetch('api.php?action=load')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#usuariosTable tbody');
            tableBody.innerHTML = '';
            data.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.nome}</td>
                    <td>${user.email}</td>
                    <td>${user.senha}</td>
                    <td>
                        <button onclick="editUser('${user._id}')">Editar</button>
                        <button onclick="deleteUser('${user._id}')">Excluir</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        });
}

function addUser() {
    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;

    fetch('api.php?action=add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ nome, email, senha })
    })
    .then(response => response.json())
    .then(() => {
        loadUsuarios();
        document.getElementById("userForm").reset();
    });
}

function editUser(userId) {
    fetch(`api.php?action=edit&id=${userId}`)
        .then(response => response.json())
        .then(user => {
            document.getElementById("userId").value = user._id;
            document.getElementById("nome").value = user.nome;
            document.getElementById("email").value = user.email;
            document.getElementById("senha").value = user.senha;
        });
}

function updateUser(userId) {
    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;

    fetch('api.php?action=update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: userId, nome, email, senha })
    })
    .then(response => response.json())
    .then(() => {
        loadUsuarios();
        document.getElementById("userForm").reset();
    });
}

function deleteUser(userId) {
    if (confirm('Tem certeza que deseja excluir?')) {
        fetch('api.php?action=delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: userId })
        })
        .then(response => response.json())
        .then(() => {
            loadUsuarios();
        });
    }
}
