async function generatePdf(objdata, fields) {
    const { PDFDocument, StandardFonts } = PDFLib;

    const formUrl = objdata.archivo_src.replace(/\//g, "\\");
    const formPdfBytes = await fetch(formUrl).then(res => res.arrayBuffer());

    const logoUrl = objdata.logo_src.replace(/\//g, "\\");
    const logoImageBytes = await fetch(logoUrl).then(res => res.arrayBuffer());

    const pdfDoc = await PDFDocument.load(formPdfBytes);
    const helvetica = await pdfDoc.embedFont(StandardFonts.Helvetica);

    const form = pdfDoc.getForm();

    for (const field of fields) {
        setVar(form, field.name, field.value(objdata), field.fontSize);
    }

    try {
        const logoImage = await pdfDoc.embedPng(logoImageBytes);
        const logoImageField = form.getButton('ImgLogo');
        logoImageField.setImage(logoImage);
    } catch (error) { }

    form.flatten();

    const pdfBytes = await pdfDoc.save();
    const pdfBlob = new Blob([pdfBytes], { type: 'application/pdf' });

    // Crear un FormData object y agregar el Blob al formulario
    const formData = new FormData();
    formData.append('pdfFile', pdfBlob, 'pdf-generated.pdf');
    formData.append('_token', objdata.token);  // Asegúrate de incluir el token CSRF

    // Enviar la solicitud POST al servidor
    await fetch(objdata.url_save, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': objdata.token,
        },
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Download the PDF file
                window.location.reload();
                download(pdfBytes, data.downloadName, "application/pdf");
                //window.open("{{ url('/storage/') }}" + "/" + data.filePath, '_blank');
            }
        })
        .catch(error => {
            Swal.close();
        });

    function setVar(form, fieldName, data, fontSize) {
        try {
            const field = form.getTextField(fieldName);
            field.defaultUpdateAppearances(helvetica);
            field.setFontSize(fontSize);
            field.setText(data);
        } catch (error) {
            console.log('Error field =>', fieldName, ' = ', data);
        }
    }
}

async function generate115(objdata) {
    const fields = [
        { name: 'NombreEmpresa', value: data => objdata.oficina_dfk.nombre_empresa, fontSize: 24 },
        { name: 'ClienteNombre', value: data => objdata.cliente_dfk.nombre_cliente, fontSize: 24 },
        { name: 'FechaFinalProyecto', value: data => objdata.proyecto_dfk.proyecto_fecha_entrega, fontSize: 24 }
    ];

    await generatePdf(objdata, fields);
}

async function generate14(objdata) {
    const fields = [];

    await generatePdf(objdata, fields);
}

async function generate140(objdata) {
    const fields = [
        { name: 'EmpresaNombre_1', value: data => objdata.oficina_dfk.empresa_nombre, fontSize: 12 },
        { name: 'EmpresaNombre_2', value: data => objdata.oficina_dfk.empresa_nombre, fontSize: 12 },
        { name: 'DireccionEmpresa', value: data => objdata.oficina_dfk.empresa_domicilio, fontSize: 12 },
        { name: 'Fecha', value: data => objdata.fecha_hoy, fontSize: 14 },
        { name: 'NombreSocio', value: data => 'Desconocido', fontSize: 12 },
    ];

    await generatePdf(objdata, fields);
}

async function generate139(objdata) {
    const fields = [
        { name: 'Fecha', value: data => objdata.fecha_hoy, fontSize: 14 },
        { name: 'NombreEmpresa', value: data => objdata.oficina_dfk.empresa_nombre, fontSize: 12 },
        { name: 'NombreCompania', value: data => objdata.cliente_dfk.cliente_nombre, fontSize: 12 },
        { name: 'fechaAnio_1', value: data => objdata.anio_actual, fontSize: 12 },
        { name: 'fechaAnio_2', value: data => objdata.anio_actual, fontSize: 9 },
    ];

    await generatePdf(objdata, fields);
}

async function generate1(objdata) {
    const fields = [];

    await generatePdf(objdata, fields);
}

async function generate9(objdata) {
    const fields = [];

    await generatePdf(objdata, fields);
}

async function generate2(objdata) {
    const fields = [];

    await generatePdf(objdata, fields);
}

async function generate3(objdata) {
    const fields = [
        { name: "Titulo", value: data => objdata.grupo_clientes, fontSize: 14 }
    ];

    await generatePdf(objdata, fields)
}
