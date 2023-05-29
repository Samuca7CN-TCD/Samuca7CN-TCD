export default function loadInstallments(config, total_value, event_date) {
    // Declaração das variaveis gerais
    let installments = [];
    const valor_total = parseFloat(total_value);
    const data_atual = new Date();
    const data_evento = new Date(event_date);
    const payment_day = config.payment_day;
    let valor_entrada = 0;
    let valor_fechamento = 0;
    let valor_restante = 0;
    const option = parseInt(config.payment_option);
    let installment_type = 0;

    // Esquematização da divisão dos valores
    switch (option) {
        case 1:
            valor_entrada = valor_total * 0.2;
            valor_fechamento = valor_total * 0.2;
            valor_restante = valor_total * 0.6;
            installment_type = 0;
            break;
        case 2:
            valor_entrada = valor_total * 0.5;
            valor_fechamento = valor_total * 0.5;
            installment_type = 2;
            break;
        case 3:
            valor_entrada = valor_total - (valor_total * 0.05);
            installment_type = 3;
            break;
        case 4:
            valor_restante = valor_total;
            installment_type = 4;
            break;
        default:
            alert("Erro! Contacte o desenvolvedor do Sistema!");
    }

    // calcular prazo para o pagamento da entrada
    let prazo_entrada = new Date(data_atual.getTime());
    let dias_uteis = 0;
    while (dias_uteis < 3) {
        prazo_entrada.setDate(prazo_entrada.getDate() + 1);
        if (prazo_entrada.getDay() !== 0 && prazo_entrada.getDay() !== 6) {
            dias_uteis++;
        }
    }

    // calcular prazo para o pagamento de fechamento
    let prazo_fechamento = new Date(data_evento.getTime());
    if (option == 1) prazo_fechamento.setDate(prazo_fechamento.getDate() - 15);
    else if (option == 2) prazo_fechamento.setDate(prazo_fechamento.getDate() - 30);

    // calcular quantidade de parcelas instermediárias
    let qtd_meses = (prazo_fechamento.getFullYear() - prazo_entrada.getFullYear()) * 12;
    if (option == 1) {
        qtd_meses -= prazo_entrada.getMonth();
        qtd_meses += (prazo_fechamento.getMonth() - 1);
        if (config.type == 1) {
            qtd_meses = parseInt(qtd_meses / 3);
            installment_type = 1;
        }

    } else if (option == 4) {
        qtd_meses -= (data_atual.getMonth() + 1);
        qtd_meses += (data_evento.getMonth() - 1);
    }
    qtd_meses = (qtd_meses <= 0) ? 1 : qtd_meses;

    // calcular valor de cada parcela intermediária
    let valor_parcela = valor_restante / qtd_meses;
    while (valor_parcela < 1000) {
        qtd_meses -= 1;
        valor_parcela = valor_restante / qtd_meses;
    }

    // settar parcela de entrada
    if (option < 4) {
        installments.push({
            id: installments.length,
            name: config.name,
            type: installment_type,
            paid_amount: 0,
            paid: 0,
            total_amount: valor_entrada,
            deadline: (new Date(prazo_entrada)).toISOString().slice(0, 19).replace('T', ' '),
            entry: true,
            vouchers: [],
        });
    }

    // settar parcelas intermediárias
    if (option == 1 || option == 4) {
        let j = 0;
        for (let i = 0; i < qtd_meses; i++) {
            installments.push({
                id: installments.length,
                name: config.name,
                type: installment_type,
                paid_amount: 0,
                paid: 0,
                total_amount: valor_parcela,
                deadline: (new Date(prazo_entrada.getFullYear(), prazo_entrada.getMonth() + 1 + j, payment_day)).toISOString().slice(0, 19).replace('T', ' '),
                entry: false,
                vouchers: [],
            });
            if (config.type == 0) {
                j++;
            } else {
                j += 3;
            }
        }
    }

    // settar parcela de fechamento
    if (option == 1 || option == 2) {
        installments.push({
            id: installments.length,
            name: config.name,
            type: installment_type,
            paid_amount: 0,
            paid: 0,
            total_amount: valor_fechamento,
            deadline: (new Date(prazo_fechamento)).toISOString().slice(0, 19).replace('T', ' '),
            entry: false,
            vouchers: [],
        });
    }

    return installments;
}