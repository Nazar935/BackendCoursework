enum DiagramAccessType {
    PRIVATE = "private",
    LIMITED = "limited",
    PUBLIC = "public",
}

enum ArrowEndpointType {
    ASSOCIATION = "Association",
    INHERITANCE = "Inheritance",
    REALIZATION = "Realization",
    DEPENDENCY = "Dependency",
    AGGREGATION = "Aggregation",
    COMPOSITION = "Composition",
}

class Point {
    x: number;
    y: number;

    constructor(x: number, y: number) {
        this.x = x;
        this.y = y;
    }

    distance(p: Point): number {
        // Обчислення відстані між двома точками
        return 0; // Placeholder
    }
}

abstract class Shape {
    coordinates: Point;
    height: number;
    width: number;

    constructor(coordinates: Point, height: number, width: number) {
        this.coordinates = coordinates;
        this.height = height;
        this.width = width;
    }

    abstract draw(): string;

    move(point: Point): void {
        // Переміщення фігури на нові координати
    }

    scale(heightScale: number, widthScale: number): void {
        // Масштабування фігури
    }
}

class Rectangle extends Shape {
    borderWidth: number;
    borderColor: string;
    backgroundColor: string;

    constructor(
        coordinates: Point,
        height: number,
        width: number,
        borderWidth: number,
        borderColor: string,
        backgroundColor: string
    ) {
        super(coordinates, height, width);
        this.borderWidth = borderWidth;
        this.borderColor = borderColor;
        this.backgroundColor = backgroundColor;
    }

    draw(): string {
        // Малювання прямокутника
        return ""; // Placeholder
    }
}

class TextShape extends Shape {
    text: string;
    font: string;
    fontSize: number;
    color: string;
    fontStyle: string;

    constructor(
        coordinates: Point,
        height: number,
        width: number,
        text: string,
        font: string,
        fontSize: number,
        color: string,
        fontStyle: string
    ) {
        super(coordinates, height, width);
        this.text = text;
        this.font = font;
        this.fontSize = fontSize;
        this.color = color;
        this.fontStyle = fontStyle;
    }

    draw(): string {
        // Малювання тексту
        return ""; // Placeholder
    }
}

class Arrow extends Shape {
    arrowStart: ArrowEndpointType;
    arrowEnd: ArrowEndpointType;
    lineWidth: number;
    lineColor: string;
    dashed: boolean;

    constructor(
        coordinates: Point,
        height: number,
        width: number,
        arrowStart: ArrowEndpointType,
        arrowEnd: ArrowEndpointType,
        lineWidth: number,
        lineColor: string,
        dashed: boolean
    ) {
        super(coordinates, height, width);
        this.arrowStart = arrowStart;
        this.arrowEnd = arrowEnd;
        this.lineWidth = lineWidth;
        this.lineColor = lineColor;
        this.dashed = dashed;
    }

    draw(): string {
        // Малювання стрілки
        return ""; // Placeholder
    }
}

class DiagramHistory {
    diagram: Diagram
    edits: string[];

    constructor(diagram: Diagram, edits: string[]) {
        this.diagram = diagram;
        this.edits = edits;
    }

    moveBackward(): void {
        // Повернення до попереднього стану
    }

    moveForward(): void {
        // Повернення до наступного стану
    }
}

class Diagram {
    diagram_id: number;
    shapes: Shape[];
    access: DiagramAccess;
    history: History;

    constructor(diagram_id: number, shapes: Shape[], access: DiagramAccess, history: History) {
        this.diagram_id = diagram_id;
        this.shapes = shapes;
        this.access = access;
        this.history = history;
    }

    addShape(shape: Shape): void {
        // Додавання фігури до діаграми
    }

    editShape(shape: Shape, edits: string): void {
        // Редагування фігури
    }

    deleteShape(shape: Shape): void {
        // Видалення фігури
    }

    export(): string {
        // Експорт діаграми у файл
        return ""; // Placeholder
    }
}

class DiagramAccess {
    type: DiagramAccessType;
    usersWithAccess: User[];

    constructor(type: DiagramAccessType, usersWithAccess: User[]) {
        this.type = type;
        this.usersWithAccess = usersWithAccess;
    }
}

class User {
    user_id: number;
    login: string;
    password: string;
    diagrams: Diagram[];

    constructor(user_id: number, login: string, password: string, diagrams: Diagram[]) {
        this.user_id = user_id;
        this.login = login;
        this.password = password;
        this.diagrams = diagrams;
    }

    createDiagram(template: Template): void {
        // Створення нової діаграми
    }

    deleteDiagram(diagram: Diagram): void {
        // Видалення діаграми
    }
}

class Admin extends User {
    testTemplates: TestTemplate[];

    constructor(user_id: number, login: string, password: string, diagrams: Diagram[], testTemplates: TestTemplate[]) {
        super(user_id, login, password, diagrams);
        this.testTemplates = testTemplates;
    }

    addNewTemplate(template: Template): void {
        // Додавання нового шаблону
    }

    addNewShape(shape: Shape): void {
        // Додавання нової фігури
    }

    deleteUser(user: User): void {
        // Видалення користувача
    }
}

class Template {
    template_id: number;
    diagram: Diagram;

    constructor(template_id: number, diagram: Diagram) {
        this.template_id = template_id;
        this.diagram = diagram;
    }
}

class TestTemplate extends Template {
    constructor(template_id: number, diagram: Diagram) {
        super(template_id, diagram);
    }

    publish(): void {
        // Публікація шаблону
    }
}
