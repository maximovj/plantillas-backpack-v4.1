crud.field('estado').onChange(function (field) {
    crud.field('empresa_municipio').hidden();
}).change();
