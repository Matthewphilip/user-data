import { defineStore } from 'pinia';

interface ClientData {
    title: string,
    first_name: string | null,
    initial: string | null,
    last_name: string
}

interface ClientStore {
    uploaded_file: File | null
    client_data: ClientData[] | null
    data_recieved: boolean
    success: {
        success_all: string | null
        success_individual: string | null
    }
    error: {
        error_all: string | null,
        error_individual: string | null,
        error_upload: string | null
    },
    loading: boolean
}

export const useClientStore = defineStore('clientStore', {
    state: (): ClientStore => ({
        uploaded_file: null,
        client_data: null,
        data_recieved: false,
        success: {
            success_all: null,
            success_individual: null,
        },
        error: {
            error_all: null,
            error_individual: null,
            error_upload: null
        },
        loading: false
    }),

    getters: {},
    actions: {
        updateClientData(newData: ClientData[]) {
            this.loading = false
            this.client_data = newData;
        },

        handleFileChange(file: File) {
            this.uploaded_file = file;
            this. uploadCSV(this.uploaded_file);

        },

        handleSubmitIndividual(clientObject: Object) {
            this.error.error_individual = null;
            this.success.success_individual = null;

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

            const requestBody = JSON.stringify({ client: clientObject });

            fetch('/api/save-individual', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken || '',
                },
                body: requestBody,
            })
            .then(response => {
                if (response.ok) {
                    this.success.success_individual = 'Client saved successfully'
                } else {
                    this.error.error_individual = 'Failed to save client data, please try again'
                }
            })
            .catch(error => {
                console.error('Error saving clients:', error);
            });
        },

        handleSubmitAll(clientsArray: Array<ClientData>) {
            this.error.error_all = null;
            this.success.success_all = null;

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

            const requestBody = JSON.stringify({ clients: clientsArray });

            fetch('/api/save-clients', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken || '',
                },
                body: requestBody,
            })
            .then(response => {
                if (response.ok) {
                    this.success.success_all = 'All clients saved successfully'
                } else {
                    this.error.error_all = 'Failed to save client data, please try again'
                    console.error('Failed to save clients');
                }
            })
            .catch(error => {
                console.error('Error saving clients:', error);
                this.error.error_all = 'Failed to save client data, please try again'
            });
        },

        async uploadCSV(file: File | null) {
            this.error.error_upload = null

            if (!file) {
                console.warn("No file selected");
                return;
            }

            console.log("file in upload: ", file);
            const formData = new FormData();
              formData.append("csv", file);
          
              const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content");
          
              try {
                this.loading = true
                const response = await fetch("/api/upload-csv", {
                  method: "POST",
                  headers: {
                    "X-CSRF-TOKEN": csrfToken || "",
                  },
                  body: formData,
                });
        
                if (response.ok) {
                  const data = await response.json();
                  console.log("CSV file uploaded successfully");
                  this.updateClientData(data);
                } else {
                    this.loading = false
                    this.error.error_upload = 'Failed to upload client data, please try again'
                    console.error("Failed to upload CSV file");
                }
              } catch (error) {
                    this.error.error_upload = 'Failed to upload client data, please try again'
                    console.error("Error uploading CSV file:", error);
              }
        }
    },
})