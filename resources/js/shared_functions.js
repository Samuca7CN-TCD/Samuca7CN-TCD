export const toMonetary = (value) => {
    if (value !== null) return value.toLocaleString('pt-br', {
        style: 'currency',
        currency: 'BRL'
    });
}

export const formatDate = (date) => {
    date = date.split(/\-|\ |\:|\T|\./);
    return date[2] + "/" + date[1] + "/" + date[0] + " às " + date[3] + ":" + date[4];
}

export const geraStringAleatoria = (tamanho) => {
    var stringAleatoria = '';
    var caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    for (var i = 0; i < tamanho; i++) {
        stringAleatoria += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
    }
    return stringAleatoria;
}