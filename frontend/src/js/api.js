const API_BASE_URL = 'http://localhost:8000';

const api = {
    async getCars() {
        const response = await fetch(`${API_BASE_URL}/cars`);
        if (!response.ok) throw new Error('Erro ao buscar carros');
        return await response.json();
    },

    async getCar(id) {
        const response = await fetch(`${API_BASE_URL}/cars/${id}`);
        if (!response.ok) throw new Error('Erro ao buscar carro');
        return await response.json();
    },

    async createCar(carData) {
        const response = await fetch(`${API_BASE_URL}/cars`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(carData)
        });
        if (!response.ok) throw new Error('Erro ao cadastrar carro');
        return await response.json();
    },

    async updateCar(id, carData) {
        const response = await fetch(`${API_BASE_URL}/cars/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(carData)
        });
        if (!response.ok) throw new Error('Erro ao atualizar carro');
        return await response.json();
    },

    async deleteCar(id) {
        const response = await fetch(`${API_BASE_URL}/cars/${id}`, {
            method: 'DELETE'
        });
        if (!response.ok) throw new Error('Erro ao deletar carro');
        return true;
    }
};