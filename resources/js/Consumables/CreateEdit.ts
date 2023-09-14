import { computed }  from 'vue'

export interface GenericRecordType {
    id: number | null,
    label: string | null,
    slug: string | null,
}

interface CreateEditProps {
    record?: never, // this could be different so only generic variables
}

interface Form {
    processing: boolean,
    isDirty: boolean,
    transform(data:object): object,
    post(route:string, data:object) : void,
    reset() : void
}

interface Routes {
    store_route?: string,
    update_route: string,
    destroy_route?: string
}

export default function(props: CreateEditProps, form: Form, routes: Routes, forceUpdate = false) {

    const editing = computed<boolean>(()=> {
        return props.record?.id !== undefined;
    })

    const disabled = computed<boolean>(() => {
        return form.processing || !form.isDirty;
    })

    function submit(): void {
        if (editing.value || forceUpdate) {
            form
                .transform((data:object) => ({...data, _method: "patch"}))
                .post(route(routes.update_route, props.record?.id));
        } else {
            form.post(route(routes.store_route), {
                onSuccess: () => form.reset(),
            });
        }
    }

    return {
        editing,
        disabled,
        submit
    }
}