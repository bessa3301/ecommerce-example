<script setup>
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardHeader, CardTitle, CardDescription, CardContent } from '@/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <Card class="border-slate-800 bg-slate-900">
        <CardHeader>
            <CardTitle class="text-white">Delete Account</CardTitle>
            <CardDescription class="text-slate-400">
                Once your account is deleted, all of its resources and data will
                be permanently deleted. Before deleting your account, please
                download any data or information that you wish to retain.
            </CardDescription>
        </CardHeader>
        <CardContent>
            <Button 
                @click="confirmUserDeletion"
                class="bg-red-600 text-white hover:bg-red-700"
            >
                Delete Account
            </Button>
        </CardContent>
    </Card>

        <Dialog :open="confirmingUserDeletion" @update:open="(val) => !val && closeModal()">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Are you sure you want to delete your account?</DialogTitle>
                    <DialogDescription>
                        Once your account is deleted, all of its resources and data
                        will be permanently deleted. Please enter your password to
                        confirm you would like to permanently delete your account.
                    </DialogDescription>
                </DialogHeader>

                <div class="space-y-2">
                    <Label for="password" class="sr-only">Password</Label>
                    <Input
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        placeholder="Password"
                        @keyup.enter="deleteUser"
                    />
                    <div v-if="form.errors.password" class="text-sm text-red-400">
                        {{ form.errors.password }}
                    </div>
                </div>

                <DialogFooter>
                    <Button variant="outline" @click="closeModal" class="border-slate-700 text-slate-300 hover:bg-slate-800">
                        Cancel
                    </Button>
                    <Button
                        :disabled="form.processing"
                        @click="deleteUser"
                        class="bg-red-600 text-white hover:bg-red-700"
                    >
                        Delete Account
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </section>
</template>
