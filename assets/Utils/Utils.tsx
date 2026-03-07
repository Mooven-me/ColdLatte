import type { paths } from '../api-types';

type HttpMethod = "POST" | "GET" | "DELETE" | "PUT" | "PATCH";

// Utility type to extract the success response from OpenAPI definitions
type ExtractOpenApiResponse<
    Path extends keyof paths,
    Method extends HttpMethod
> = Lowercase<Method> extends keyof paths[Path]
    ? paths[Path][Lowercase<Method>] extends {
          responses: {
              200: { content: { "application/json": infer Res } };
          };
      }
        ? Res
        : never // Fallback if no 200 JSON response is defined
    : never; // Fallback if method doesn't exist on path

interface RouteArgs<Base extends string, Route extends string, Method extends HttpMethod> {
    route: Route;
    basePath?: Base;
    method?: Method;
    data?: object;
}

export const sendData = async <
    Base extends string = "/api",
    Route extends string = string,
    Method extends HttpMethod = "POST",
    FullPath extends keyof paths = `${Base}${Route}` extends keyof paths ? `${Base}${Route}` : never
>({
    route,
    data = {},
    method = "POST" as Method,
    basePath = "/api" as Base,
}: RouteArgs<Base, Route, Method>): Promise<ExtractOpenApiResponse<FullPath, Method> | { error: true; error_message: any }> => {
    let options: { method: string; headers: Record<string, string>; body?: string } = {
        method: method,
        headers: {}
    }
    options.headers['Accept'] = 'application/json';
    
    if (method === "POST") {
        options.headers['Content-Type'] = 'application/json';
        options.body = JSON.stringify(data);
    }

    try {
        const response = await fetch("/" + basePath + route, options);
        
        if (response.status === 401) {
            let jwtResponse = await fetch("/api/token/refresh")
            if (!jwtResponse.ok) {
                setTimeout(() => {
                    window.location.href = '/';
                }, 1500);
                throw new Error("Votre session à expiré");
            }
            // Pass the generic arguments back recursively
            return sendData({ route, method, data, basePath });
        }

        if (response.status === 500) {
            let result = await response.json()
            throw new Error(result.detail)
        }
        
        const result = await response.json();
        
        if (result.error === 1 && result.error_message) {
            throw new Error(result.error_message);
        }
        
        // Assert the returned value as your dynamically extracted type
        return (result.data ?? result) as ExtractOpenApiResponse<FullPath, Method>;
        
    } catch (error) {
        return { error: true, error_message: error };
    }
}

export function sendDataLoader<
    Route extends string,
    Method extends HttpMethod
>(route: Route, method: Method) {
    return () => {
        const promise = sendData({ route, method });
        return { data: promise };
    };
}