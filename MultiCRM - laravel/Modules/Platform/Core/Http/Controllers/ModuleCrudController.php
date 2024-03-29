<?php

namespace Modules\Platform\Core\Http\Controllers;

use Cog\Contracts\Ownership\Ownable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Core\Notifications\GenericNotification;
use Modules\Platform\Core\Datatable\ActivityLogDataTable;
use Modules\Platform\Core\Datatable\DictionaryDatatable;
use Modules\Platform\Core\Datatable\PlatformDataTable;
use Modules\Platform\Core\Datatable\Scope\OwnableEntityScope;
use Modules\Platform\Core\Entities\CsvData;
use Modules\Platform\Core\Helper\CrudHelper;
use Modules\Platform\Core\Helper\CsvImporter;
use Modules\Platform\Core\Helper\Excel\RecordImport;
use Modules\Platform\Core\Helper\StringHelper;
use Modules\Platform\Core\Helper\ValidationHelper;
use Modules\Platform\Core\Http\Requests\CsvImportRequest;
use Modules\Platform\Core\Repositories\AdvancedViewRepository;
use Modules\Platform\Core\Repositories\GenericRepository;
use Modules\Platform\Core\Traits\CrudEventsTrait;
use Modules\Platform\Core\Traits\ModuleOwnableTrait;
use Modules\Platform\Notifications\Entities\NotificationPlaceholder;
use Modules\Platform\User\Entities\Group;
use Modules\Platform\User\Entities\User;
use Stringy\Stringy;

/**
 * Class ModuleCrudController
 *
 * @package Modules\Platform\Core\Http\Controllers
 */
abstract class ModuleCrudController extends AppBaseController
{
    use FormBuilderTrait, ModuleOwnableTrait, CrudEventsTrait;

    const ACTIVITY_LOG_EXTENSION = 'Spatie\Activitylog\Traits\LogsActivity';

    const COMMENTS_EXTENSION = 'Modules\Platform\Core\Traits\Commentable';

    const ATTACHMENT_EXTENSION = 'Bnb\Laravel\Attachments\HasAttachment';

    const FORM_MODE_FULL = 'full';

    const FORM_MODE_SIMPLE = 'modal';

    const ACTION_MASS_UPDATE = 'mass_update';


    /**
     * DataTable in list view (index)
     * @var
     */
    protected $datatable;

    protected $formModalCssClass = null;

    protected $formModalCssId = null;

    protected $disableNextPrev = true;

    protected $settingsMode = false;

    protected $moduleDictionary = false;

    protected $disableTabs = false;

    protected $skipPermissionCheck = false;

    protected $demoMode = false;

    protected $disableWidgets = false;

    protected $allowForceDelete = false;

    /**
     * Default Crud view
     * @var array
     */
    protected $views = [
        'index' => 'core::crud.module.index',
        'show' => 'core::crud.module.show',
        'create' => 'core::crud.module.create',
        'edit' => 'core::crud.module.edit',
        'import' => 'core::crud.module.import',
        'import_process' => 'crud::crud.module.import_process'
    ];

    /**
     * Link for settings in module
     * @var array
     */
    protected $moduleSettingsLinks = [

    ];
    /**
     * Permission for settings
     * @var string
     */
    protected $settingsPermission = '';
    /**
     * Link for back button from settings to main module
     * @var string
     */
    protected $settingsBackRoute = '';
    /**
     * Permissions
     * @var array
     */
    protected $permissions = [
        'browse' => '',
        'create' => '',
        'update' => '',
        'destroy' => ''
    ];
    /**
     * Path to language files
     * @var
     */
    protected $languageFile;
    /**
     * All routes
     * @var array
     */
    protected $routes = [

    ];
    /**
     * Show fields in show view and create/edit view
     *
     * Example @UserController
     *
     * @var array
     */
    protected $showFields = [

    ];

    /**
     * Related Tabs
     * @var array
     */
    protected $relationTabs = [

    ];

    protected $baseIcons = [
        'details_icon' => true,
        'details_label' => true,
        'comments_icon' => true,
        'comments_label' => true,
        'attachments_icon' => true,
        'attachments_label' => true,
        'activity_log_icon' => true,
        'activity_log_label' => true
    ];

    /**
     * Show custom buttons in show view
     * Example @UserController
     * @var array
     */
    protected $customShowButtons = [];


    /**
     * Mass  Action Buttons
     * @var array
     */
    protected $massActionButtons = [];

    protected $showMassActionButtons = false;

    protected $showMassDeleteButton = true;

    protected $showMassUpdateButton = true;

    protected $moduleUrl = '';

    /**
     * Show action button on show view
     * Default action button (copy)
     * @var array
     */
    protected $actionButtons = [];

    /**
     * More dropdown on index
     * @var array
     */
    protected $indexActionButtons = [];

    /***
     * Form section buttons
     * Example @InvoiceController
     * @var array
     */
    protected $sectionButtons = [];

    /**
     * Module Repository
     * @var
     */
    protected $repository = GenericRepository::class;

    /**
     * Module Entity Class
     * @var
     */
    protected $entityClass;

    /**
     * Module Store Request
     * @var
     */
    protected $storeRequest;
    /**
     * Module Update Request
     * @var
     */
    protected $updateRequest;


    /**
     * Entity Form Class
     * @var
     */
    protected $formClass;
    /**
     * Module name - same as module folder
     * Example
     * - User Module = "expenses"
     * @var
     */
    protected $moduleName;

    /**
     * Module Entity
     * @var
     */
    protected $entity;

    /**
     * @var
     */
    protected $entityIdentifier;

    /**
     * Additional JavaScript Files to include
     * @var array
     */
    protected $jsFiles = [];

    /**
     * Additioanl CSS Files to include
     * @var array
     */
    protected $cssFiles = [];

    /**
     * Additional view to include
     * Works with show,create,edit - use for modals!
     * @var array
     */
    protected $includeViews = [

    ];

    /**
     * SettingsCrudController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        \View::share('language_file', $this->languageFile);
        \View::share('routes', $this->routes);
        \View::share('jsFiles', $this->jsFiles);
        \View::share('cssFiles', $this->cssFiles);
        \View::share('moduleName', $this->moduleName);
        \View::share('includeViews', $this->includeViews);
        \View::share('moduleSettingsLinks', $this->moduleSettingsLinks);
        \View::share('settingsPermission', $this->settingsPermission);
        \View::share('settingsBackRoute', $this->settingsBackRoute);
        \View::share('permissions', $this->permissions);
        \View::share('settingsMode', $this->settingsMode);
        \View::share('moduleDictionary', $this->moduleDictionary);
        \View::share('disableTabs', $this->disableTabs);

        $this->validateModule();
    }

    /**
     * Validate module controller setup
     * @throws \Exception
     */
    public function validateModule()
    {
        if ($this->repository == null && $this->entityClass == null) {
            throw new \Exception('Please set repository or entityClass in Controller');
        }
        if ($this->datatable == null) {
            throw new \Exception('Please set DataTableClass');
        }
        if ($this->formClass == null) {
            throw new \Exception('Please set FormClass');
        }
        if ($this->storeRequest == null || $this->updateRequest == null) {
            throw new \Exception('Please set storeRequest and updateRequest');
        }
    }

    public function indexRedirect()
    {
        return \Redirect::to(route($this->routes['index']));
    }

    protected $datatableColumns = [];

    /**
     * Show module DataTable
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $datatable = \App::make($this->datatable);

        if($this->datatable == DictionaryDatatable::class){
            $datatable->setEloquentModel(App::make($this->entityClass));
            $datatable->setRoutes([
                'show' => $this->routes['show'],
                'edit' => $this->routes['edit']
            ]);
            if(count($this->datatableColumns) > 0 ) {
                $datatable->setColumns($this->datatableColumns);
            }
        }

        $additionalVariables = [];

        $this->beforeIndex($request, $datatable, $additionalVariables);

        $filters = $request->get('rules', null);
        $advancedView = (int)$request->get('advView', null);

        $advancedViewRepo = \App::make(AdvancedViewRepository::class);

        if (!empty($filters)) {
            $datatable->applyFilterRules($filters);
        }


        $currentAdvView = null;

        if (!empty($advancedView) && $advancedView > 0) {

            $currentAdvView = $advancedViewRepo->findWithoutFail($advancedView);

            if (!empty($currentAdvView) && $currentAdvView->isVisible()) {
                $datatable->applyAdvancedView($currentAdvView, $this->moduleName);
            }
        }


        if ($this->scopedAccess() && !$this->moduleDictionary) {
            $datatable->addScope(new OwnableEntityScope(\Auth::user(), $this->moduleName, $this->entityClass));
        }

        $indexView = $this->views['index'];

        if ($request->get('mode', self::FORM_MODE_FULL) == self::FORM_MODE_SIMPLE) {
            $indexView = 'core::crud.module.modal-datatable';

            $datatable->tableMode = PlatformDataTable::TABLE_MODE_MODAL;
            $datatable->relationMode = true;
            $datatable->setTableId('RelatedModalTable');
            $datatable->setAjaxSource(route($this->routes['index']));

            if ($tableClass = $request->get('customTableClass')) {
                $datatable->setAdditionalTableClass($tableClass);

            }

            return $datatable->render($indexView);
        }

        /**
         * Quick edit is enable only for Full Table Mode
         */
        if ($this->permissions['update'] != '' && \Auth::user()->hasPermissionTo($this->permissions['update'])) {
            $datatable->allowQuickEdit = true;
        }

        if ($this->showMassActionButtons) {
            $datatable->allowSelect = true;
        }

        $this->indexActionButtons();
        $this->setupMassActionButtons();


        return $datatable->render($indexView, [
            'indexActionButtons' => $this->indexActionButtons,
            'massActionButtons' => $this->massActionButtons,
            'showMassActionButtons' => $this->showMassActionButtons,
            'advancedViewsEnabled' => config($this->moduleName . '.advanced_views', false),
            'listViews' => $advancedViewRepo->getForModule($this->moduleName),
            'currentView' => $advancedView,
            'currentAdvView' => $currentAdvView,
            'availableColumns' => $datatable->availableColumns(),
            'dataTableDef' => $datatable,
            'disableWidgets' => $this->disableWidgets

        ], $additionalVariables);
    }


    /**
     * Show entity create form
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        if ($this->permissions['create'] != '' && !\Auth::user()->hasPermissionTo($this->permissions['create'])) {
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        $this->beforeCreate($request);
        $this->setupCreateFormData();

        $fillModel = $request->all();

        $fillModel = array_merge($fillModel, $this->createFormData);


        $action = $request->get('action', null);

        $copy = $request->get('copy', null);
        if ($copy) {

            $repository = $this->getRepository();

            $copyFrom = $repository->findWithoutFailForCopy((int)$copy);

            if (!empty($copy)) {
                $fillModel = $copyFrom;
            }
        }

        $url = route($this->routes['store']);

        if (self::ACTION_MASS_UPDATE == $action) {
            $url = route($this->moduleName . '.' . $this->moduleName . '.mass_update');
        }

        $createForm = $this->form($this->formClass, [
            'method' => 'POST',
            'url' => $url,
            'id' => 'module_form',
            'model' => $fillModel
        ]);


        $createView = $this->views['create'];

        $mode = $request->get('mode', 'full');

        if ($mode == self::FORM_MODE_SIMPLE) {
            $createView = 'core::crud.module.create_form';
        }

        $view = view($createView);

        $view->with('modal_form', false);

        if ($mode == self::FORM_MODE_SIMPLE) {
            $formId = uniqid('form_');

            $view->with('modal_form', true);
            $createForm->setFormOption('id', $formId);
            if ($this->formModalCssClass != null) {
                $createForm->setFormOption('class', $this->formModalCssClass);
            } else {
                $createForm->setFormOption('class', 'module_form related-modal-form');
            }
            if ($this->formModalCssId != null) {
                $createForm->setFormOption('id', $this->formModalCssId);
            }

            $view->with('formId', $formId);
            $createForm->add('entityCreateMode', 'hidden', [
                'value' => 'modal'
            ]);
            $createForm->add('relationType', 'hidden', [
                'value' => $request->get('relationType')
            ]);
            $createForm->add('relatedField', 'hidden', [
                'value' => $request->get('relatedField')
            ]);
            $createForm->add('relatedEntityId', 'hidden', [
                'value' => $request->get('relatedEntityId')
            ]);

            $createForm->add('relatedEntity', 'hidden', [
                'value' => $request->get('relatedEntity')
            ]);

            if (self::ACTION_MASS_UPDATE == $action) {
                $createForm->add('mass_action_ids', 'hidden', [
                    'value' => '',

                ]);
                $createForm->setFormOption('class', "module_form related-modal-form mass_update_form");
            }
        }

        $view->with('form_request', $this->storeRequest);
        $view->with('sectionButtons', $this->sectionButtons);

        if (self::ACTION_MASS_UPDATE == $action) {
            $view->with('form_request', null);
            $view->with('massUpdateMode', true);

            foreach ($createForm->getFields() as $field) {

                if (isset($field->getOptions()['removeFromMassUpdate']) && $field->getOptions()['removeFromMassUpdate']) {
                    $createForm->remove($field->getName());

                    $this->showFields = array_map(function (array $elem) use ($field) {
                        unset($elem[$field->getName()]);
                        return $elem;
                    }, $this->showFields);
                }
            }

            $this->showFields = array_filter($this->showFields);

        } else {
            $view->with('massUpdateMode', false);
        }

        $view->with('show_fields', $this->showFields);


        return $view->with('form', $createForm);
    }

    /**
     * Show entity details
     *
     * @param $identifier
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($identifier)
    {
        if ($this->permissions['browse'] != '' && !\Auth::user()->hasPermissionTo($this->permissions['browse'])) {
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        $repository = $this->getRepository();


        $entity = $repository->find($identifier);

        $this->entity = $entity;

        if (empty($entity)) {
            flash(trans('core::core.entity.entity_not_found'))->error();

            return redirect(route($this->routes['index']));
        }

        if ($this->blockEntityOwnableAccess()) {
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        $this->entityIdentifier = $entity->id;


        $showView = $this->views['show'];

        $this->entity = $entity;

        if (request('mode') == 'json') {
            return response()->json($this->entity);
        }


        $this->beforeShow(request(), $entity);

        if (request('mode') == 'modal') {
            $view = view('core::crud.module.show_form');
        } else {
            $view = view($showView);
        }


        $view->with('entity', $entity);
        $view->with('show_fields', $this->showFields);
        $view->with('show_fileds_count', count($this->showFields));

        if (!$this->disableNextPrev) {
            $view->with('next_record', $repository->next($entity));
            $view->with('prev_record', $repository->prev($entity));
        }

        $view->with('disableNextPrev', $this->disableNextPrev);

        $this->setupCustomButtons();
        $this->setupActionButtons();
        $view->with('customShowButtons', $this->customShowButtons);
        $view->with('actionButtons', $this->actionButtons);
        $view->with('commentableExtension', false);
        $view->with('actityLogDatatable', null);
        $view->with('attachmentsExtension', false);
        $view->with('entityIdentifier', $this->entityIdentifier);


        $view->with('hasExtensions', false);

        $view->with('relationTabs', $this->setupRelationTabs($entity));

        $view->with('baseIcons', $this->baseIcons);

        /*
         * Extensions
         */
        if (in_array(self::COMMENTS_EXTENSION, class_uses($this->entity))) {
            $view->with('commentableExtension', true);
            $view->with('hasExtensions', true);
        }
        if (in_array(self::ACTIVITY_LOG_EXTENSION, class_uses($this->entity))) {
            $activityLogDataTable = \App::make(ActivityLogDataTable::class);
            $activityLogDataTable->setEntityData(get_class($entity), $entity->id);
            $view->with('actityLogDatatable', $activityLogDataTable->html());
            $view->with('hasExtensions', true);
        }
        if (in_array(self::ATTACHMENT_EXTENSION, class_uses($this->entity))) {
            $view->with('attachmentsExtension', true);
            $view->with('hasExtensions', true);
        }


        return $view;
    }

    /**
     * Create instance of module repository or use generic repository
     *
     * @return mixed
     */
    protected function getRepository()
    {
        if ($this->repository == GenericRepository::class) {
            $repository = \App::make($this->repository);
            $repository->setupModel($this->entityClass);
        } else {
            $repository = \App::make($this->repository);
        }

        return $repository;
    }

    /**
     * Setup custom buttons
     */
    protected function setupCustomButtons()
    {

    }

    /**
     * Process import
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function importProcess(Request $request)
    {
        ini_set('max_execution_time', 0);

        $data = CsvData::find($request->get('file_id'));

        $repository = $this->getRepository();

        if (!empty($data)) {

            $csvData = json_decode($data->csv_data, true);

            $imported = 0;
            $notImported = 0;

            $errors = [];

            $requestFields = $request->get('fields');

            $entityClass = \App::make($this->entityClass);

            $csvImporter = new CsvImporter();
            $csvImporter->setEntity($entityClass);
            $csvImporter->setFields($this->showFields);
            $csvImporter->setRelations(CrudHelper::relationships($entityClass));
            $csvImporter->setRepo($repository);

            unset($csvData[0]); // remove header

            foreach ($csvData as $rowKey => $row) {

                try {

                    $fields = [];

                    foreach ($requestFields as $key => $field) {
                        $fields[$field] = $row[$key];
                    }

                    $entity = $csvImporter->createEntity($fields);

                    if (!empty($entity)) {
                        $imported++;
                    }

                } catch (\Exception $exception) {
                    $notImported++;


                    Log::error($exception);
                }

            }

            flash(trans('core::core.import_finished', ['imported' => $imported, 'not_imported' => $notImported]))->info();
            return redirect()->route($this->routes['index']);


        } else {

            flash(trans('core::core.cannot_process_import'))->error();
            return redirect()->route($this->routes['index']);

        }

    }

    /**
     * Prepare import
     *
     * @param CsvImportRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    protected function import(CsvImportRequest $request)
    {

        try {

            if (\Auth::user()->hasPermissionTo($this->permissions['create'])) {

                $path = $request->file('csv_file');

                $importConfig = [
                    'delimiter' => $request->get('delimiter')
                ];

                $data = Excel::toArray(new RecordImport($importConfig), $path);

                $data = $data[0];

                if (count($data) > 0) {

                    $view = view($this->views['import']);

                    $csv_header_fields = [];
                    foreach ($data[0] as $value) {
                        $csv_header_fields[$value] = $value;
                    }

                    foreach ($data as &$row) {
                        $row = array_combine($csv_header_fields, $row);
                    }

                    $view->with('csv_header', $csv_header_fields);

                    $csvDataFile = CsvData::create([
                        'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                        'csv_header' => 1,
                        'csv_data' => json_encode($data)
                    ]);


                    $csvData = array_slice($data, 0, 2);

                    $moduleFields = \App::make($this->entityClass)->fillable;

                    $moduleFields = CrudHelper::removeValues($moduleFields, [
                        'id', 'company_id', 'full_name'
                    ]);

                    $view->with('csvDataFile', $csvDataFile);
                    $view->with('module_fields', $moduleFields);
                    $view->with('csv_data', $csvData);

                    return $view;
                } else {

                    flash(trans('core::core.empty_file'))->error();

                    return redirect()->back();
                }

            }

            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);

        } catch (\Exception $exception) {
            flash(trans('core::core.invalid_file'))->error();
        }

    }

    protected function indexActionButtons()
    {

        $noPermissionIsRequired = (array_key_exists('create', $this->permissions) && $this->permissions['create'] == '');
        $hasPermissionifRequired = (isset($this->permissions['create']) && $this->permissions['create'] != '' && \Auth::user()->hasPermissionTo($this->permissions['create']));

        if ($noPermissionIsRequired || $hasPermissionifRequired) {

            $this->indexActionButtons[] = array(
                'href' => '#',
                'attr' => [
                    'class' => ['quick_create']
                ],
                'label' => trans('core::core.btn.quick_create')
            );
            if (isset($this->routes['import'])) {
                $this->indexActionButtons[] = array(
                    'href' => '#',
                    'attr' => [
                        'class' => ['records_import']
                    ],
                    'label' => trans('core::core.btn.import')
                );
            }

        }

    }

    protected function setupActionButtons()
    {
        $this->actionButtons[] = array(
            'href' => route($this->routes['create'], ['copy' => $this->entity->id]),
            'attr' => [

            ],
            'label' => trans('core::core.btn.copy')
        );
    }

    protected function setupMassActionButtons()
    {
        if ($this->showMassDeleteButton) {
            $this->massActionButtons[] = array(
                'href' => route($this->routes['destroy'], 'id'),
                'attr' => [
                    'class' => 'index-mass-delete mass-action-href waves-effect waves-block',
                    'force-delete' => 0
                ],
                'label' => trans('core::core.btn.delete')
            );

            $this->massActionButtons[] = array(
                'href' => route($this->routes['destroy'], 'id'),
                'attr' => [
                    'class' => 'index-mass-delete mass-action-href waves-effect waves-block',
                    'force-delete' => 1
                ],
                'label' => trans('core::core.btn.mass_delete')
            );
        }

        if ($this->showMassUpdateButton) {
            $this->massActionButtons[] = array(
                'href' => '#',
                'attr' => [
                    'class' => 'index-mass-update mass-action-href waves-effect waves-block',
                ],
                'label' => trans('core::core.btn.mass_update')
            );
        }
    }


    /**
     * Setup entity relations to other modules
     *
     * @param mixed $entity Entity object
     *
     * @return array
     */
    protected function setupRelationTabs($entity)
    {
        foreach ($this->relationTabs as $tabKey => $tab) {

            /// Related elements Datatable
            $linkedDataTable = \App::make($tab['datatable']['datatable']);

            $entityId = $entity->id;

            $linkedDataTable->setEntityData(get_class($entity), $entityId, $tab['route']['linked']);

            if (isset($tab['permissions']['update']) && \Auth::user()->hasPermissionTo($tab['permissions']['update'])) {
                $linkedDataTable->allowUnlink = true;
            }

            if (isset($tab['permissions']['delete']) && \Auth::user()->hasPermissionTo($tab['permissions']['delete'])) {
                $linkedDataTable->allowDelete = true;
            }

            $this->relationTabs[$tabKey]['htmlTable'] = $linkedDataTable->html();
            $this->relationTabs[$tabKey]['create']['post_create_bind']['mode'] = 'modal';
            $this->relationTabs[$tabKey]['create']['post_create_bind']['relatedEntityId'] = $this->entityIdentifier;
            $this->relationTabs[$tabKey]['create']['post_create_bind']['relatedEntity'] = $this->entityClass;

            if ($this->relationTabs[$tabKey]['create']['post_create_bind']['relationType'] == 'oneToMany') {
                $this->relationTabs[$tabKey]['create']['post_create_bind'][$this->relationTabs[$tabKey]['create']['post_create_bind']['relatedField']] = $this->entityIdentifier;
            }

            /// Link new elements Datatable
            $newRecordsDataTable = \App::make($tab['datatable']['datatable']);
            $newRecordsDataTable->setEntityData(get_class($entity), $entityId, $tab['route']['select']);
            $newRecordsDataTable->selectMode();
            $newRecordsDataTable->allowSelect = true;
            //$newRecordsDataTable->allowSelect = true;

            $this->relationTabs[$tabKey]['newRecordsTable'] = $newRecordsDataTable->html();
        }

        return $this->relationTabs;
    }


    /**
     * Store entity
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        $request = \App::make($this->storeRequest ?? Request::class);

        $mode = $request->get('entityCreateMode', self::FORM_MODE_FULL);

        if ($this->demoMode) {
            if (config('bap.demo')) {

                if ($mode == self::FORM_MODE_FULL) {
                    flash(trans('core::core.you_cant_do_that_its_demo'))->error();
                    return redirect()->back();
                } else {
                    return response()->json([
                        'type' => 'error',
                        'message' => trans('core::core.you_cant_do_that_its_demo'),
                        'action' => 'refresh_datatable'
                    ]);
                }

            }
        }

        if ($this->permissions['create'] != '' && !\Auth::user()->hasPermissionTo($this->permissions['create'])) {
            if ($mode == self::FORM_MODE_SIMPLE) {
                return response()->json([
                    'type' => 'error',
                    'message' => trans('core::core.entity.you_dont_have_access'),
                    'action' => 'show_message'
                ]);
            }
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        $repository = $this->getRepository();

        $storeValues = $this->form($this->formClass)->getFieldValues(true);

        if ($mode == self::FORM_MODE_SIMPLE) {

            //Bind related element
            $relatedEntityId = $request->get('relatedEntityId');
            $relationType = $request->get('relationType', null);
            $relatedField = $request->get('relatedField');
            $relatedEntity = $request->get('relatedEntity');

            if ($relationType != null) { // Relation type is not null



                $relationEntityRepos = \App::make(GenericRepository::class);
                $relationEntityRepos->setupModel($relatedEntity);

                $relationEntity = $relationEntityRepos->findWithoutFail($relatedEntityId);

                if ($relationType == 'oneToMany') {
                    $storeValues[$relatedField] = $relationEntity->id;
                }
            }
        }

        $this->beforeStore($request);

        $entity = $repository->createEntity($storeValues, \App::make($this->entityClass));

        $entity = $this->setupAssignedTo($entity, $request, true);
        $entity->save();

        $this->afterStore($request, $entity);


        if (config('bap.record_assigned_notification_enabled')) {

            if ($entity instanceof Ownable) {
                if ($entity->getOwner() != null && $entity->getOwner() instanceof User) {
                    if ($entity->getOwner()->id != \Auth::user()->id) { // Dont send notification for myself
                        try {
                            $commentOn = $entity->name;
                            $commentOn = ' - ' . $commentOn;
                        } catch (\Exception $exception) {
                            $commentOn = '';
                        }

                        $placeholder = new NotificationPlaceholder();

                        $placeholder->setRecipient($entity->getOwner());
                        $placeholder->setAuthorUser(\Auth::user());
                        $placeholder->setAuthor(\Auth::user()->name);
                        $placeholder->setColor('bg-green');
                        $placeholder->setIcon('assignment');
                        $placeholder->setContent(trans('notifications::notifications.new_record', ['user' => \Auth::user()->name]) . $commentOn);

                        $placeholder->setUrl(route($this->routes['show'], $entity->id));

                        $entity->getOwner()->notify(new GenericNotification($placeholder));
                    }
                }
            }
        }

        if ($mode == self::FORM_MODE_SIMPLE) {

            //Bind related element
            $relatedEntityId = $request->get('relatedEntityId');
            $relationType = $request->get('relationType', null);
            $relatedField = $request->get('relatedField');
            $relatedEntity = $request->get('relatedEntity');

            if ($relationType != null) { // Relation type is not null

                $relationEntityRepos = \App::make(GenericRepository::class);
                $relationEntityRepos->setupModel($relatedEntity);


                $relationEntity = $relationEntityRepos->findWithoutFail($relatedEntityId);


                if ($relationType == 'manyToMany') {
                    $entity->{$relatedField}()->attach($relationEntity->id);
                }
            }

            return response()->json([
                'type' => 'success',
                'message' => trans('core::core.entity.created'),
                'action' => 'refresh_datatable'
            ]);
        }

        flash(trans('core::core.entity.created'))->success();

        return redirect(route($this->routes['index']));
    }

    /**
     * Setup Assigned (User|Group)
     *
     * @param mixed $entity - Entity object
     * @param array $input Values from request
     * @param bool $creating - creating mode
     *
     * @return mixed
     */
    protected function setupAssignedTo($entity, $input, $creating = false)
    {
        if ($entity instanceof Ownable) {
            if (isset($input['owned_by'])) {
                $owner = Stringy::create($input['owned_by']);
            } else {
                $owner = '';
            }

            if ($owner != '') {
                if ($owner->startsWith('user-')) {
                    $owner = $owner->replace('user-', '');

                    $entity->changeOwnerTo(User::find($owner));
                } else {
                    $owner = $owner->replace('group-', '');
                    $entity->changeOwnerTo(Group::find($owner));
                }
            } else {
                if (!$creating) {
                    $entity->abandonOwner();
                }
            }
        }

        return $entity;
    }

    /**
     * Show entity edit form
     *
     * @param $identifier
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($identifier)
    {


        if ($this->permissions['update'] != '' && !\Auth::user()->hasPermissionTo($this->permissions['update'])) {
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        $repository = $this->getRepository();

        $entity = $repository->find($identifier);

        $this->entity = $entity;


        if (empty($entity)) {
            flash(trans('core::core.entity.entity_not_found'))->error();

            return redirect(route($this->routes['index']));
        }

        if ($this->blockEntityOwnableAccess()) {
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        $updateForm = $this->form($this->formClass, [
            'method' => 'PATCH',
            'url' => route($this->routes['update'], $entity),
            'id' => 'module_form',
            'model' => $entity
        ]);

        $updateView = $this->views['edit'];

        $mode = request()->get('mode', 'full');

        if ($mode == self::FORM_MODE_SIMPLE) {
            $updateView = 'core::crud.module.edit_form';
        }

        $view = view($updateView);

        $view->with('modal_form', false);

        $this->entity = $entity;

        if ($mode == self::FORM_MODE_SIMPLE) {

            $formId = uniqid('form_');

            $view->with('modal_form', true);
            $updateForm->setFormOption('id', $formId);
            if ($this->formModalCssClass != null) {
                $updateForm->setFormOption('class', $this->formModalCssClass);
            } else {
                $updateForm->setFormOption('class', 'module_form update-related-modal-form');
            }
            if ($this->formModalCssId != null) {
                $updateForm->setFormOption('id', $this->formModalCssId);
            }

            $view->with('formId', $formId);
            $updateForm->add('entityCreateMode', 'hidden', [
                'value' => 'modal'
            ]);
            $updateForm->add('relationType', 'hidden', [
                'value' => request()->get('relationType')
            ]);
            $updateForm->add('relatedField', 'hidden', [
                'value' => request()->get('relatedField')
            ]);
            $updateForm->add('relatedEntityId', 'hidden', [
                'value' => request()->get('relatedEntityId')
            ]);

            $updateForm->add('relatedEntity', 'hidden', [
                'value' => request()->get('relatedEntity')
            ]);
        }

        $view->with('form_request', $this->updateRequest);
        $view->with('entity', $entity);
        $view->with('show_fields', $this->showFields);
        $view->with('sectionButtons', $this->sectionButtons);

        $this->beforeEdit(request(), $entity);

        return $view->with('form', $updateForm);


    }

    public function massUpdate(Request $request)
    {

        if (config('bap.demo')) {

            return response()->json([
                'type' => 'error',
                'message' => trans('core::core.you_cant_do_that_its_demo'),
                'action' => 'show_message'

            ]);

        }

        if ($this->permissions['update'] != '' && !\Auth::user()->hasPermissionTo($this->permissions['update'])) {
            return response()->json([
                'type' => 'error',
                'message' => trans('core::core.you_dont_have_access'),
                'action' => 'show_message'
            ]);
        }

        $entityIds = explode(",", $request->get('mass_action_ids', ''));

        $repository = $this->getRepository();

        $input = $this->form($this->formClass)->getFieldValues(false);

        foreach ($entityIds as $entityId) {

            $entity = $repository->find($entityId);

            $this->entity = $entity;

            if (!empty($entity)) { // entity exists
                if (!$this->blockEntityOwnableAccess()) { // user has access to entity

                    $this->beforeUpdate(request(), $entity, $input);

                    $entity = $this->setupAssignedTo($entity, $input);

                    $repository = $this->getRepository();

                    $entity = $repository->updateEntity($input, $entity);

                    $this->afterUpdate(request(), $entity, $repository);

                    $this->entity = $entity;
                }
            }
        }


        return response()->json([
            'type' => 'success',
            'message' => trans('core::core.entity.updated'),
            'action' => 'refresh_datatable'
        ]);

    }

    /**
     * Update entity
     *
     * @param $identifier
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($identifier)
    {
        $request = \App::make($this->updateRequest ?? Request::class);

        $mode = $request->get('entityCreateMode', self::FORM_MODE_FULL);

        if ($this->demoMode) {
            if (config('bap.demo')) {

                if ($mode == self::FORM_MODE_FULL) {
                    flash(trans('core::core.you_cant_do_that_its_demo'))->error();
                    return redirect()->back();
                } else {
                    return response()->json([
                        'type' => 'error',
                        'message' => trans('core::core.you_cant_do_that_its_demo'),
                        'action' => 'refresh_datatable'
                    ]);
                }

            }
        }

        if ($this->permissions['update'] != '' && !\Auth::user()->hasPermissionTo($this->permissions['update'])) {
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }


        $repository = $this->getRepository();

        $entity = $repository->find($identifier);

        $this->entity = $entity;

        if (empty($entity)) {
            flash(trans('core::core.entity.entity_not_found'))->error();

            return redirect(route($this->routes['index']));
        }

        if ($this->blockEntityOwnableAccess()) {
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        $input = $this->form($this->formClass)->getFieldValues(true);

        $currentOwner = null;
        if ($entity instanceof Ownable && $entity->hasOwner()) {
            $currentOwner = $entity->getOwner();
        }

        $this->beforeUpdate(request(), $entity, $input);

        $entity = $this->setupAssignedTo($entity, $input);

        $repository = $this->getRepository();

        $entity = $repository->updateEntity($input, $entity);

        $this->afterUpdate(request(), $entity, $repository);

        $this->entity = $entity;

        if ($mode == self::FORM_MODE_SIMPLE) {
            return response()->json([
                'type' => 'success',
                'message' => trans('core::core.entity.updated'),
                'action' => 'refresh_datatable'
            ]);
        }

        flash(trans('core::core.entity.updated'))->success();


        return redirect(route($this->routes['show'], $entity));
    }


    /**
     * @param $identifier
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($identifier)
    {
        $request = request();

        $mode = $request->get('entityCreateMode', self::FORM_MODE_FULL);


        if (config('bap.demo')) {

            if ($mode == self::FORM_MODE_FULL) {
                flash(trans('core::core.you_cant_do_that_its_demo'))->error();
                return redirect()->back();
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => trans('core::core.you_cant_do_that_its_demo'),
                    'action' => 'show_message'
                ]);
            }

        }


        if ($this->permissions['destroy'] != '' && !\Auth::user()->hasPermissionTo($this->permissions['destroy'])) {

            if ($mode == self::FORM_MODE_FULL) {

                flash(trans('core::core.you_dont_have_access'))->error();
                return redirect()->route($this->routes['index']);

            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => trans('core::core.you_dont_have_access'),
                    'action' => 'show_message'
                ]);
            }

        }

        $repository = $this->getRepository();

        $entity = $repository->find($identifier);

        $this->entity = $entity;


        if (empty($entity)) {

            if ($mode == self::FORM_MODE_FULL) {

                flash(trans('core::core.entity.entity_not_found'))->error();
                return redirect(route($this->routes['index']));

            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => trans('core::core.you_dont_have_access'),
                    'action' => 'none'
                ]);
            }

        }

        if ($this->blockEntityOwnableAccess()) {

            if ($mode == self::FORM_MODE_FULL) {

                flash(trans('core::core.you_dont_have_access'))->error();
                return redirect()->route($this->routes['index']);

            } else {

                return response()->json([
                    'type' => 'error',
                    'message' => trans('core::core.you_dont_have_access'),
                    'action' => 'none'
                ]);
            }
        }

        $forceDelete = \request()->get('force_delete', 0);

        if($this->allowForceDelete){
            $forceDelete = true;
        }

        if (!$forceDelete ) {

            if (config('bap.validate_fk_on_soft_delete')) {
                $validator = ValidationHelper::validateForeignKeys($entity);

                if (count($validator) > 0) {

                    if ($mode == self::FORM_MODE_FULL) {

                        flash(trans('core::core.cant_delete_check_fk_keys', ['fk_keys' => StringHelper::validationArrayToString($validator)]))->error();

                        return redirect(route($this->routes['index']));

                    } else {
                        return response()->json([
                            'type' => 'error',
                            'message' => trans('core::core.cant_delete_check_fk_keys', ['fk_keys' => StringHelper::validationArrayToString($validator)]),
                            'action' => 'show_message'
                        ]);
                    }


                }
            }
        }

        $this->beforeDestroy(request(), $entity);

        $repository->delete($entity->id);

        $this->afterDestroy(request());

        if ($mode == self::FORM_MODE_FULL) {
            flash(trans('core::core.entity.deleted'))->success();
            return redirect(route($this->routes['index']));

        } else {
            return response()->json([
                'type' => 'success',
                'message' => trans('core::core.entity.deleted'),
                'action' => 'refresh_datatable'
            ]);
        }


    }
}
