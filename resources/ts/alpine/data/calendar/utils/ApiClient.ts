import axios, {
    type AxiosInstance,
    type AxiosRequestConfig,
    type AxiosResponse,
} from "axios";

class ApiClient {
    private apiVersion: string = "v1";
    private client: AxiosInstance;

    constructor() {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content");

        this.client = axios.create({
            baseURL: `/api/${this.apiVersion}`,
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": csrfToken || "",
            },
            withCredentials: true,
        });

        this.initializeInterceptors();
    }

    private initializeInterceptors(): void {
        this.client.interceptors.response.use(
            (response) => response,
            (error) => {
                if (error.response?.status === 401) {
                    console.error("Unauthorized");
                }

                if (error.response?.status === 419) {
                    console.error("CSRF token mismatch");
                }

                return Promise.reject(error);
            },
        );
    }

    public async get<T>(url: string, config?: AxiosRequestConfig): Promise<T> {
        try {
            const response: AxiosResponse<T> = await this.client.get(
                url,
                config,
            );
            return response.data;
        } catch (error: any) {
            error.success = false;
            return error.response.data;
        }
    }

    public async post<T>(
        url: string,
        data?: unknown,
        config?: AxiosRequestConfig,
    ): Promise<T> {
        try {
            const response: AxiosResponse<T> = await this.client.post(
                url,
                data,
                config,
            );
            return response.data;
        } catch (error: any) {
            error.success = false;
            return error.response.data;
        }
    }

    public async put<T>(
        url: string,
        data?: unknown,
        config?: AxiosRequestConfig,
    ): Promise<T> {
        try {
            const response: AxiosResponse<T> = await this.client.put(
                url,
                data,
                config,
            );
            return response.data;
        } catch (error: any) {
            error.success = false;
            return error.response.data;
        }
    }

    public async delete<T>(
        url: string,
        config?: AxiosRequestConfig,
    ): Promise<T> {
        try {
            const response: AxiosResponse<T> = await this.client.delete(
                url,
                config,
            );
            return response.data;
        } catch (error: any) {
            error.success = false;
            return error.response.data;
        }
    }
}

export const api = new ApiClient();
