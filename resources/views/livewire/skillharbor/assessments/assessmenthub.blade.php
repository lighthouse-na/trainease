<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.app.header')] class extends Component {
    //
}; ?>

<div>

    <div class="container mx-auto p-12 max-w-4xl">

        <!-- Breadcrumb -->
        <nav class="text-sm mb-6 text-gray-500">
            <ol class="list-reset flex">
                <li><a href="/" class="text-sky-700 hover:underline">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="#" class="text-sky-700 hover:underline">My Assessments</a></li>
            </ol>
        </nav>

        <!-- Header Section with Job Info and Qualifications -->
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white border border-gray-200 rounded-lg p-5 flex flex-col">
                <h2 class="text-lg font-semibold text-sky-800 mb-3">Job Competency Profile</h2>
                <div class="space-y-2">
                    <p class="text-gray-600"><strong>Employee:</strong> John Doe</p>
                    <p class="text-gray-600"><strong>Job Title:</strong> Network Engineer</p>
                    <p class="text-gray-600"><strong>Job Grade:</strong> D2</p>
                    <p class="text-gray-600"><strong>Job Purpose:</strong> Maintain network infrastructure.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <h2 class="text-lg font-semibold text-sky-800 mb-3">Required Qualifications</h2>
                <ul class="space-y-2">
                    <li class="flex justify-between items-center">
                        <span>BSc in Computer Science</span>
                        <span class="text-green-600 font-semibold">Attained</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span>CCNA Certification</span>
                        <span class="text-red-500 font-semibold">Missing</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Download Button Section -->
        <div class="mb-6 flex justify-end">
            <flux:button
                as="a"
                href="#"
                variant="filled"
                class="text-sm font-semibold text-white bg-sky-700 hover:bg-sky-800 rounded-lg px-5 py-2.5"
                icon="arrow-down"
                icon:variant="outline"
            >
                Download Supervisor Report
            </flux:button>
        </div>

        <!-- Skill Audit Table -->
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6">
            <div class="bg-sky-800 text-white px-4 py-3 font-medium grid grid-cols-4 text-center">
                <div>Skill</div>
                <div>Required</div>
                <div>User Rating</div>
                <div>Supervisor Rating</div>
            </div>
            <div class="divide-y">
                <!-- Skill Row Example -->
                <div class="grid grid-cols-4 px-4 py-3 text-center text-sm items-center hover:bg-gray-50 transition-colors">
                    <div class="text-left font-medium text-gray-800">Network Troubleshooting</div>
                    <div><flux:button variant="filled" size="xs" class="bg-green-500 text-white rounded-full">5</flux:button></div>
                    <div><flux:button variant="filled" size="xs" class="bg-yellow-300 text-black rounded-full">3</flux:button></div>
                    <div><flux:button variant="filled" size="xs" class="bg-green-300 text-black rounded-full">4</flux:button></div>
                </div>
                <div class="grid grid-cols-4 px-4 py-3 text-center text-sm items-center bg-gray-50 hover:bg-gray-100 transition-colors">
                    <div class="text-left font-medium text-gray-800">Security Auditing</div>
                    <div><flux:button variant="filled" size="xs" class="bg-orange-400 text-white rounded-full">2</flux:button></div>
                    <div><flux:button variant="filled" size="xs" class="bg-orange-400 text-white rounded-full">2</flux:button></div>
                    <div><flux:button variant="filled" size="xs" class="bg-red-500 text-white rounded-full">1</flux:button></div>
                </div>
                <!-- Add more rows dynamically -->
            </div>
        </div>

    </div>
</div>
