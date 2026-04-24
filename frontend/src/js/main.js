document.addEventListener('DOMContentLoaded', () => {
    
    const carTableBody = document.getElementById('car-table-body');
    const tableHeaderRow = document.getElementById('table-header-row');
    if (carTableBody) {
        loadCars();
    }

    const addCarForm = document.getElementById('add-car-form');
    const dynamicFieldsContainer = document.getElementById('dynamic-fields-container');

    if (addCarForm && dynamicFieldsContainer) {
        const formFields = Car.getFormFields();
        
        formFields.forEach(field => {
            const fieldWrapper = document.createElement('div');
            fieldWrapper.className = 'field-wrapper';
            
            if (field.label) {
                const labelElement = document.createElement('label');
                labelElement.htmlFor = field.id;
                labelElement.textContent = field.label;
                fieldWrapper.appendChild(labelElement);
            }

            let element;
            
            if (field.type === 'textarea') {
                element = document.createElement('textarea');
            } else {
                element = document.createElement('input');
                element.type = field.type;
            }
            
            element.id = field.id;
            
            if (field.placeholder) {
                element.placeholder = field.placeholder;
            }
            
            if (field.required) {
                element.required = true;
            }
            
            fieldWrapper.appendChild(element);
            dynamicFieldsContainer.appendChild(fieldWrapper);
        });

        addCarForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            
            const carData = {};
            
            formFields.forEach(field => {
                const element = document.getElementById(field.id);
                let value = element.value;
                
                if (field.type === 'number') {
                    value = value ? parseInt(value) : null;
                }
                
                carData[field.id] = value;
            });

            const car = new Car(carData);
            const messageDiv = document.getElementById('message');

            try {
                await car.save();
                
                messageDiv.textContent = 'Carro cadastrado com sucesso!';
                messageDiv.style.color = 'green';
                
                addCarForm.reset();
            } catch (error) {
                messageDiv.textContent = 'Erro ao cadastrar carro. Verifique o console.';
                messageDiv.style.color = 'red';
            }
        });
    }

    async function loadCars() {
        try {
            const tableFields = Car.getFormFields();
            
            if (tableHeaderRow) {
                tableHeaderRow.innerHTML = '<th>ID</th>';
                tableFields.forEach(field => {
                    const th = document.createElement('th');
                    th.textContent = field.label || field.placeholder || field.id;
                    tableHeaderRow.appendChild(th);
                });
            }

            const cars = await Car.getAll();
            carTableBody.innerHTML = '';
            
            if (cars.length === 0) {
                carTableBody.innerHTML = `<tr><td colspan="${tableFields.length + 1}">Nenhum carro cadastrado ainda.</td></tr>`;
                return;
            }

            cars.forEach(car => {
                const tr = document.createElement('tr');
                tr.innerHTML = `<td>${car.id}</td>`;
                
                tableFields.forEach(field => {
                    const td = document.createElement('td');
                    td.textContent = car[field.id] !== null && car[field.id] !== undefined ? car[field.id] : '';
                    tr.appendChild(td);
                });

                carTableBody.appendChild(tr);
            });
        } catch (error) {
            carTableBody.innerHTML = `<tr><td colspan="${Car.getFormFields().length + 1}">Erro ao carregar dados da API.</td></tr>`;
        }
    }
});