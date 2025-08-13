<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

include '../config/database.php';

$page_title = 'Manage Contacts - Admin - F24Tech';
$success = '';
$error = '';

// Handle status updates
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    try {
        $contact_id = (int)$_POST['contact_id'];
        $status = $_POST['status'];
        
        DB::update('contact_submissions', 
            ['status' => $status], 
            ['id' => $contact_id]
        );
        
        $success = 'Contact status updated successfully!';
    } catch (Exception $e) {
        $error = 'Error updating status: ' . $e->getMessage();
    }
}

// Handle delete
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'delete') {
    try {
        $contact_id = (int)$_POST['contact_id'];
        DB::delete('contact_submissions', ['id' => $contact_id]);
        $success = 'Contact deleted successfully!';
    } catch (Exception $e) {
        $error = 'Error deleting contact: ' . $e->getMessage();
    }
}

// Get filters
$status_filter = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';

// Build query
$where_conditions = [];
$params = [];

if ($status_filter) {
    $where_conditions[] = "status = ?";
    $params[] = $status_filter;
}

if ($search) {
    $where_conditions[] = "(name LIKE ? OR email LIKE ? OR company LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$where_clause = $where_conditions ? 'WHERE ' . implode(' AND ', $where_conditions) : '';
$contacts = DB::query("SELECT * FROM contact_submissions $where_clause ORDER BY created_at DESC", $params)->fetchAll();

include '../includes/admin-header.php';
?>

<div class="min-h-screen bg-gray-50 pt-16">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Manage Contacts</h1>
                    <p class="text-gray-600">View and manage contact form submissions</p>
                </div>
                <a href="index.php" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form method="GET" class="flex flex-wrap gap-4 items-center">
                <div>
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
                           placeholder="Search contacts..." 
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="new" <?php echo $status_filter === 'new' ? 'selected' : ''; ?>>New</option>
                        <option value="contacted" <?php echo $status_filter === 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                        <option value="qualified" <?php echo $status_filter === 'qualified' ? 'selected' : ''; ?>>Qualified</option>
                        <option value="closed" <?php echo $status_filter === 'closed' ? 'selected' : ''; ?>>Closed</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Filter
                </button>
                <a href="manage-contacts.php" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    Clear
                </a>
            </form>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php if ($success): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($contacts): ?>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Contact</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Company</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Service</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Budget</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($contacts as $contact): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                <?php echo htmlspecialchars($contact['name']); ?>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <?php echo htmlspecialchars($contact['email']); ?>
                                            </div>
                                            <?php if ($contact['phone']): ?>
                                                <div class="text-sm text-gray-500">
                                                    <?php echo htmlspecialchars($contact['phone']); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <?php echo htmlspecialchars($contact['company'] ?? 'N/A'); ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <?php echo htmlspecialchars($contact['service_interest'] ?? 'N/A'); ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <?php echo htmlspecialchars($contact['budget_range'] ?? 'N/A'); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form method="POST" class="inline">
                                            <input type="hidden" name="action" value="update_status">
                                            <input type="hidden" name="contact_id" value="<?php echo $contact['id']; ?>">
                                            <select name="status" onchange="this.form.submit()" 
                                                    class="text-xs font-semibold rounded-full px-2 py-1 border-0 <?php 
                                                    echo $contact['status'] === 'new' ? 'bg-green-100 text-green-800' : 
                                                        ($contact['status'] === 'contacted' ? 'bg-blue-100 text-blue-800' : 
                                                        ($contact['status'] === 'qualified' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800')); 
                                                    ?>">
                                                <option value="new" <?php echo ($contact['status'] ?? 'new') === 'new' ? 'selected' : ''; ?>>New</option>
                                                <option value="contacted" <?php echo ($contact['status'] ?? 'new') === 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                                                <option value="qualified" <?php echo ($contact['status'] ?? 'new') === 'qualified' ? 'selected' : ''; ?>>Qualified</option>
                                                <option value="closed" <?php echo ($contact['status'] ?? 'new') === 'closed' ? 'selected' : ''; ?>>Closed</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <?php echo date('M j, Y', strtotime($contact['created_at'])); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <button onclick="showMessage(<?php echo $contact['id']; ?>)" 
                                                    class="text-blue-600 hover:text-blue-800 p-1" title="View Message">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                </svg>
                                            </button>
                                            <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>?subject=Re: Your inquiry&body=Hi <?php echo htmlspecialchars($contact['name']); ?>,%0A%0AThank you for your inquiry..." 
                                               class="text-green-600 hover:text-green-800 p-1" title="Reply via Email">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                            </a>
                                            <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this contact?')">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="contact_id" value="<?php echo $contact['id']; ?>">
                                                <button type="submit" class="text-red-600 hover:text-red-800 p-1" title="Delete Contact">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Hidden message row -->
                                <tr id="message-<?php echo $contact['id']; ?>" class="hidden bg-gray-50">
                                    <td colspan="7" class="px-6 py-4">
                                        <div class="bg-white p-4 rounded-lg">
                                            <h4 class="font-semibold text-gray-900 mb-2">Message:</h4>
                                            <p class="text-gray-700 whitespace-pre-wrap"><?php echo htmlspecialchars($contact['message']); ?></p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="text-gray-500 mb-4">No contacts found</div>
            </div>
        <?php endif; ?>

        <!-- Stats -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-4 gap-6">
            <?php
            $total_contacts = count($contacts);
            $new_contacts = count(array_filter($contacts, fn($c) => ($c['status'] ?? 'new') === 'new'));
            $contacted = count(array_filter($contacts, fn($c) => ($c['status'] ?? 'new') === 'contacted'));
            $qualified = count(array_filter($contacts, fn($c) => ($c['status'] ?? 'new') === 'qualified'));
            ?>
            <div class="bg-blue-50 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2"><?php echo $total_contacts; ?></div>
                <div class="text-gray-600">Total Contacts</div>
            </div>
            <div class="bg-green-50 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-green-600 mb-2"><?php echo $new_contacts; ?></div>
                <div class="text-gray-600">New</div>
            </div>
            <div class="bg-purple-50 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2"><?php echo $contacted; ?></div>
                <div class="text-gray-600">Contacted</div>
            </div>
            <div class="bg-orange-50 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-orange-600 mb-2"><?php echo $qualified; ?></div>
                <div class="text-gray-600">Qualified</div>
            </div>
        </div>
    </div>
</div>

<script>
function showMessage(contactId) {
    const messageRow = document.getElementById('message-' + contactId);
    if (messageRow.classList.contains('hidden')) {
        messageRow.classList.remove('hidden');
    } else {
        messageRow.classList.add('hidden');
    }
}
</script>

<?php include '../includes/admin-footer.php'; ?>