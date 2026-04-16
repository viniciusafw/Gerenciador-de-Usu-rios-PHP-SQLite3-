<?php

require_once 'db.php';

// Deletar
if (isset($_GET['deletar'])) {
    $id = (int) $_GET['deletar'];
    $db->exec("DELETE FROM usuarios WHERE id = $id");
    header("Location: index.php?msg=deletado");
    exit;
}

// Salvar (Insert/Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome     = $db->escapeString($_POST['nome']);
    $email    = $db->escapeString($_POST['email']);
    $telefone = $db->escapeString($_POST['telefone']);

    if (!empty($_POST['id'])) {
        $id = (int) $_POST['id'];
        $db->exec("UPDATE usuarios SET nome='$nome', email='$email', telefone='$telefone' WHERE id=$id");
        header("Location: index.php?msg=atualizado");
    } else {
        $db->exec("INSERT INTO usuarios (nome, email, telefone) VALUES ('$nome', '$email', '$telefone')");
        header("Location: index.php?msg=criado");
    }
    exit;
}

// Buscar dados para editar
$editando = null;
if (isset($_GET['editar'])) {
    $id = (int) $_GET['editar'];
    $editando = $db->querySingle("SELECT * FROM usuarios WHERE id = $id", true);
}

// Lista todos os usuários
$resultado = $db->query("SELECT * FROM usuarios ORDER BY id DESC");
$usuarios = [];
while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
    $usuarios[] = $row;
}

include 'header.php';
?>

<div class="container py-5">
    <h2 class="mb-4 fw-bold text-center">
        <i class="bi bi-people-fill text-primary"></i> Gerenciar Usuários
    </h2>

    <?php if (isset($_GET['msg'])): 
        $msgs = [
            'criado'     => ['success', 'bi-check-circle-fill', 'Usuário criado!'],
            'atualizado' => ['success', 'bi-check-circle-fill', 'Usuário atualizado!'],
            'deletado'   => ['danger',  'bi-trash-fill',        'Usuário removido!'],
        ];
        $m = $msgs[$_GET['msg']] ?? null;
        if ($m): ?>
            <div class="alert alert-<?= $m[0] ?> alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi <?= $m[1] ?>"></i> <?= $m[2] ?>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; 
    endif; ?>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white fw-semibold py-3">
                    <i class="bi <?= $editando ? 'bi-pencil-fill' : 'bi-person-plus-fill' ?>"></i>
                    <?= $editando ? ' Editar Usuário' : ' Novo Usuário' ?>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="index.php">
                        <?php if ($editando): ?>
                            <input type="hidden" name="id" value="<?= $editando['id'] ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nome</label>
                            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($editando['nome'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">E-mail</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($editando['email'] ?? '') ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Telefone</label>
                            <input type="text" name="telefone" class="form-control" value="<?= htmlspecialchars($editando['telefone'] ?? '') ?>">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">Salvar</button>
                            <?php if ($editando): ?>
                                <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white fw-semibold py-3 d-flex align-items-center justify-content-between">
                    <span>Lista de Usuários</span>
                    <span class="badge bg-primary rounded-pill"><?= count($usuarios) ?></span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Nome</th>
                                <th>E-mail</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $u): ?>
                            <tr>
                                <td class="ps-4 fw-semibold"><?= htmlspecialchars($u['nome']) ?></td>
                                <td class="text-muted small"><?= htmlspecialchars($u['email']) ?></td>
                                <td class="text-center">
                                    <a href="index.php?editar=<?= $u['id'] ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                    <a href="index.php?deletar=<?= $u['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>