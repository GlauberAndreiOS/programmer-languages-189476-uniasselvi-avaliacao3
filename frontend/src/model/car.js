class Car {
    constructor(data = {}) {
        this.id = data.id || null;
        this.placa = data.placa || '';
        this.marca = data.marca || '';
        this.modelo = data.modelo || '';
        this.ano_fabricacao = data.ano_fabricacao || null;
        this.ano_modelo = data.ano_modelo || null;
        this.cor = data.cor || '';
        this.combustivel = data.combustivel || '';
        this.quilometragem = data.quilometragem || null;
        this.chassi = data.chassi || '';
        this.renavam = data.renavam || '';
        this.data_cadastro = data.data_cadastro || '';
        this.observacoes = data.observacoes || '';
    }

    static getFormFields() {
        return [
            { id: 'placa', label: 'Placa', type: 'text', placeholder: 'Placa (ex: ABC1234)', required: true },
            { id: 'marca', label: 'Marca', type: 'text', placeholder: 'Marca', required: true },
            { id: 'modelo', label: 'Modelo', type: 'text', placeholder: 'Modelo', required: true },
            { id: 'ano_fabricacao', label: 'Ano Fab.', type: 'number', placeholder: 'Ano Fabricação', required: true },
            { id: 'ano_modelo', label: 'Ano Mod.', type: 'number', placeholder: 'Ano Modelo', required: true },
            { id: 'cor', label: 'Cor', type: 'text', placeholder: 'Cor', required: true },
            { id: 'combustivel', label: 'Combustível', type: 'text', placeholder: 'Combustível', required: true },
            { id: 'quilometragem', label: 'KM', type: 'number', placeholder: 'Quilometragem', required: true },
            { id: 'chassi', label: 'Chassi', type: 'text', placeholder: 'Chassi', required: true },
            { id: 'renavam', label: 'Renavam', type: 'text', placeholder: 'Renavam', required: true },
            { id: 'data_cadastro', label: 'Data Cadastro', type: 'date', required: true },
            { id: 'observacoes', label: 'Obs.', type: 'textarea', placeholder: 'Observações', required: false }
        ];
    }

    static async getAll() {
        const carsData = await api.getCars();
        return carsData.map(data => new Car(data));
    }

    static async getById(id) {
        const data = await api.getCar(id);
        return new Car(data);
    }

    async save() {
        if (this.id) {
            const data = await api.updateCar(this.id, this);
            Object.assign(this, data);
        } else {
            const data = await api.createCar(this);
            Object.assign(this, data);
        }
        return this;
    }

    async delete() {
        if (!this.id) throw new Error("Carro não possui ID para deletar");
        await api.deleteCar(this.id);
        return true;
    }
}